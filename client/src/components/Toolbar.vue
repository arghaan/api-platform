<template>
    <div>
        <v-app-bar
                app
                clipped-left
                class="elevation-4"
        >
            <v-app-bar-nav-icon
                    class="mr-12 ml-0 nav-icon"
                    @click.stop="mini = !mini"
            >
            </v-app-bar-nav-icon>
            <v-toolbar-title class="py-2 mr-12">
                <v-img
                        :src="require('../assets/logo.svg')"
                        contain
                        width="200"
                >
                </v-img>
            </v-toolbar-title>
            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn
                        v-for="(item, key) in menu"
                        :key="key"
                        :to="item.href"
                        text
                >
                    <v-icon class="pr-2" large :color="item.icon_color">{{item.icon}}</v-icon>
                    {{item.title}}
                </v-btn>
            </v-toolbar-items>
            <v-spacer></v-spacer>
            <v-menu>
                <template v-slot:activator="{ on }">
                    <v-app-bar-nav-icon class="hidden-md-and-up" v-on="on"></v-app-bar-nav-icon>
                </template>
                <v-list>
                    <v-list-item v-for="(item, key) in menu" :key="key">
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
            <v-text-field
                    prepend-inner-icon="search"
                    class="search-btn mr-5 hidden-sm-and-down"
                    single-line
                    label="Search..."
            ></v-text-field>
            <profile></profile>
        </v-app-bar>
        <v-navigation-drawer
                app
                v-model="drawer"
                :mini-variant.sync="mini"
                permanent
                clipped
        >
            <v-list
                    dense
                    nav
                    class="py-0"
            >
                <v-list-item></v-list-item>
                <v-list-item
                        v-for="item in s_menu"
                        :key="item.title"
                        link
                        :to="item.href"
                >

                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
    </div>
</template>

<script>
    import Profile from "./Profile";

    export default {
        name: "Toolbar",
        components: {Profile},
        data() {
            return {
                menu: [
                    {icon: 'mdi-view-dashboard', icon_color: '#006d8d', title: 'Home', href: '/'},
                    {icon: 'widgets', title: 'Ozon', href: '/ozon'},
                    {icon: 'gavel', title: 'beri.ru', href: '/beri'},
                    // {icon: '', title: 'Link 3', href: '#/3'},
                    // {icon: '', title: 'Link 4', href: '#/4'},
                ],
                drawer: true,
                s_menu: [
                    {title: 'Панель управления', icon: 'mdi-view-dashboard', href: '/'},
                    {title: 'Категории', icon: 'mdi-folder-multiple', href: '/categories'},
                    {title: 'Продукты', icon: 'mdi-file-multiple', href: 'products'},
                    {title: 'Загрузить из магазина', icon: 'mdi-briefcase-download'},
                    {title: 'Выгрузить в магазин', icon: 'mdi-briefcase-upload'},
                    {title: 'Помошь', icon: 'mdi-help-box'},
                ],
                color: 'primary',
                background: true,
                mini: false,
            }
        },
        computed: {
            bg() {
                return this.background ? 'https://cdn.vuetifyjs.com/images/backgrounds/bg-2.jpg' : undefined
            },
        },
    }
</script>

<style scoped lang="scss">
    .v-menu {
        button {
            border: 1px solid black;
            border-radius: 3px;
            width: 100px;
        }

        &__content {
            width: 100% !important;
        }
    }

    .nav-icon span i {
        &:before {
            font-size: 40px;
        }
    }
</style>
