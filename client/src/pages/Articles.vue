<template>
    <div>
        <article-item
                v-for="(item, key) in articles"
                :key=key
                :item=item
                :index=key
        ></article-item>
    </div>
</template>

<script>
    import ArticleItem from '../components/ArticleItem'

    export default {
        name: "Articles",
        components: {
            ArticleItem
        },
        data() {
            return {
                articles: [
                    {
                        title: 'Title ',
                        text: `
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vitae risus ut metus gravida congue in ac nisl. Praesent leo urna, venenatis sit amet tortor vitae, commodo tincidunt libero. Maecenas porta pharetra sem, vel dapibus odio eleifend non. Suspendisse lobortis ipsum at diam congue condimentum. Mauris aliquam, dolor in gravida sagittis, metus metus tincidunt nisi, a blandit nisl leo consequat purus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam et nunc condimentum, consequat mauris ut, accumsan sem.

                        Aliquam eu porta lacus. Sed condimentum congue orci eget consectetur. Curabitur convallis arcu porta volutpat venenatis. Vivamus lorem massa, blandit vehicula egestas id, tempor et nibh. Sed ut mattis velit. Pellentesque eget fermentum massa. Sed dictum tincidunt aliquam. Nullam porta risus ac leo fringilla vehicula. Aenean sed placerat arcu.

                        Ut vulputate aliquam leo vitae tristique. Nunc sollicitudin ligula est, sit amet euismod lacus finibus vel. Praesent a tincidunt turpis, et suscipit risus. Phasellus enim risus, sollicitudin eu erat ac, lacinia viverra ante. Nulla finibus eleifend dignissim. Suspendisse mollis neque et lectus sagittis, vel volutpat justo dignissim. Nunc consectetur nisi quis orci pretium, a finibus ipsum vulputate. Donec turpis nisi, semper eget posuere at, porttitor facilisis nibh.

                        Etiam quis nisl turpis. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Mauris finibus tellus ante, et mattis dui molestie bibendum. Donec dui leo, finibus et mollis sit amet, maximus at nunc. Nulla at aliquam ipsum. Ut varius, risus vitae suscipit tempus, risus sem fermentum nulla, non ultrices orci lacus id magna. Phasellus velit tortor, ullamcorper eget nisi vitae, imperdiet eleifend risus. Maecenas est eros, fermentum vel fermentum eu, porta in mi. Sed consequat dolor non ligula ultricies, eu sagittis odio sagittis. Fusce diam augue, elementum faucibus lacus sed, aliquet lobortis nisl. Fusce fringilla fringilla auctor. Aliquam sagittis vehicula lorem, eget lacinia elit finibus non. Pellentesque tempus augue sit amet mauris volutpat, ut tristique elit congue.

                        In diam risus, fringilla at varius ac, consectetur vitae lacus. Nam viverra nec quam nec cursus. Nulla facilisi. Nunc at mi non mi ullamcorper placerat vel ut dolor. Quisque diam libero, semper eget vestibulum in, suscipit blandit mi. Morbi dignissim, dui id hendrerit rutrum, libero ante dignissim augue, et hendrerit ipsum nunc nec nisi. Quisque vel lacus sapien. Vivamus lobortis sem quis nulla ornare, nec dapibus odio venenatis. Ut vulputate mattis augue ac sagittis. Aliquam tellus sapien, lacinia ac quam at, aliquet porta massa. Mauris lacus ipsum, lobortis ac lacus quis, gravida vehicula ligula.
                        `,
                        author: 'Unknown Author',
                        comments: 0
                    }
                ]
            }
        },
        created() {
            this.$store.dispatch('product/fetchProducts');
        },
        computed: {
            isLoading () {
                return this.$store.getters['product/isLoading'];
            },
            hasError () {
                return this.$store.getters['product/hasError'];
            },
            error () {
                return this.$store.getters['product/error'];
            },
            hasProducts () {
                return this.$store.getters['product/hasPosts'];
            },
            products () {
                return this.$store.getters['product/posts'];
            },
        },
    }
</script>

<style scoped>

</style>
