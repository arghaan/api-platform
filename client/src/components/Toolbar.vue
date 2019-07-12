<template>
    <v-toolbar app class="elevation-4">
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
                    flat
            >
                {{item.title}}
            </v-btn>
        </v-toolbar-items>
        <v-spacer></v-spacer>
        <v-btn icon>
            <v-icon>search</v-icon>
        </v-btn>
        <profile></profile>
        <v-menu class="hidden-md-and-up">
            <v-toolbar-side-icon slot="activator"></v-toolbar-side-icon>
            <v-list>
                <v-list-tile v-for="(item, key) in menu" :key="key">
                    <v-list-tile-content>
                        <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-menu>
    </v-toolbar>
</template>

<script>
    import Profile from "./Profile";
    export default {
        name: "Toolbar",
        components: {Profile},
        data(){
            return {
                menu: [
                    {icon: '', title: 'Link 1', href: '#/1'},
                    {icon: '', title: 'Link 2', href: '#/2'},
                    {icon: '', title: 'Link 3', href: '#/3'},
                    {icon: '', title: 'Link 4', href: '#/4'},
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