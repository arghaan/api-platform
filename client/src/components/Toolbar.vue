<template>
    <v-app-bar app class="elevation-4">
        <v-toolbar-title class="py-2 mr-5">
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
                <v-icon class="pr-2">{{item.icon}}</v-icon>
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
</template>

<script>
    import Profile from "./Profile";

    export default {
        name: "Toolbar",
        components: {Profile},
        data() {
            return {
                menu: [
                    {icon: 'widgets', title: 'Ozon', href: '/ozon'},
                    {icon: 'gavel', title: 'beri.ru', href: '/beri'},
                    // {icon: '', title: 'Link 3', href: '#/3'},
                    // {icon: '', title: 'Link 4', href: '#/4'},
                ]
            }
        }
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
</style>
