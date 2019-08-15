<?php

namespace App\Controller;

use DOMDocument;
use Dompdf\Dompdf;
use Dompdf\Exception;
use Dompdf\Options;
use DOMXPath;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class MilalikaParserController
 * @package App\Controller
 */
class MilalikaParserController extends AbstractController
{
    /**
     * @var Filesystem
     */
    private $fs;

    /**
     * MilalikaParserController constructor.
     * @param Filesystem $fs
     */
    public function __construct(Filesystem $fs)
    {
        $this->fs = $fs;
    }


    /**
     * @Route("/milalika/parser", name="milalika_parser")
     * @param HttpClientInterface $httpClient
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(HttpClientInterface $httpClient)
    {
        $browser = new HttpBrowser($httpClient);
        $browser->request('GET', 'https://www.milalika.com/');
        $browser->clickLink('Вход');
        $browser->submitForm('Войти', [
            'log' => 'zhanna_per',
            'pwd' => 'arg2018',
            'rememberme' => 'forever'
        ]);
        $res = $browser->request('GET', '/lessone/?id=124'); // Дл и ДП
//        $res = $browser->request('GET', '/lessone/?id=100'); // НГВЛ 19
        $nodes = [];
        $res->filter('.dt-sc-toggle-frame')
            ->each(function (Crawler $node, $i) use (&$nodes) {

                $nodes[] = [
                    'text' => sprintf("%03d", $i) . '_' . preg_replace('/[.:()\/!\"]/', '', $node->filter('h5 a')->text()),
                    'link' => $node->filter('h5 a')->attr('href')
                ];
            });
        $this->fs->remove('/var/www/html/public/111');
        foreach ($nodes as $key => $node) {
//            if ($key > 2) break;
            if ($node['link'] != '#') {
                $crawler = $browser->request('GET', $node['link']);
                $html = $crawler->filter('.entry-body')->html();
                libxml_use_internal_errors(true);
                $dom = new DOMDocument();
                $dom->loadHTML('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . $html);
                libxml_clear_errors();
                $xpath = new DOMXPath($dom);
                $pDivs = $xpath->query(".//div[contains(@class, 'row')]");
                $links = '';
                foreach ($pDivs as $div) {
                    /** @noinspection PhpUndefinedMethodInspection */
                    if (preg_match('/wida-(.+)/', $div->getAttribute('class'), $matches)) {
                        $el = $dom->createElement("img");
                        $el->setAttribute('src', "https://img.youtube.com/vi/{$matches[1]}/0.jpg");
                        $div->parentNode->replaceChild($el, $div);
                        $links .= "https://www.youtube.com/watch?v=" . $matches[1] . "\n";
                    }
                }
                $this->fs->dumpFile("./111/{$node['text']}/yt.txt", $links);
                $pDivs = $xpath->query(".//div[contains(@class, 'author-bio')] | .//input | .//style | .//script");
                foreach ($pDivs as $div) {
                    $div->parentNode->removeChild($div);
                }
                $html = $dom->saveHTML();
                $html .= <<<EOL
<style>
img {
    width: 100%;
    height: auto;
}
</style>
EOL;
//                $this->fs->dumpFile("./111/{$node['text']}/{$node['text']}.html", $html);
                $this->toPDF($node['text'], $html);
            }
        }
        echo 'Done';
        return $this->render('milalika_parser/index.html.twig', [
        ]);
    }

    /**
     * @Route("/milalika/toPDF", name="milalika_toPDF")
     * @param $name
     * @param $html
     * @return Response
     */
    public function toPDF($name, $html)
    {
        $pdfOptions = new Options();
        $pdfOptions->setIsRemoteEnabled(true)
            ->setChroot('/var/www/html/public/')
            ->setDefaultFont('dejavu serif')
            ->setIsJavascriptEnabled(true);
        $pdf = new Dompdf($pdfOptions);
        try {
            $pdf->loadHtml($html);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            file_put_contents("/var/www/html/public/111/$name/$name.pdf", $pdf->output());
        } catch (Exception $e) {
            dump($e);
        }

        return new Response();
    }

}
