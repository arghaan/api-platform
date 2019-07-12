<template>
    <v-menu offset-y class="wrapper">
        <template slot="activator">
            <i v-if="avatar === ''" class="material-icons" slot="activator">
                account_circle
            </i>
            <span v-if="name !== ''" class="name">{{name}}</span>
        </template>
        <v-list>
            <v-list-tile>
                <v-list-tile-content>
                    <v-list-tile-title>Login</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>
    </v-menu>
</template>

<script>
    export default {
        name: "Profile",
        data() {
            return {
                avatar: '',
                name: '',
                menu: [
                    {icon: '', title: 'Login', href: '#/login'}
                ]
            }
        },
        created() {
        }
    }
</script>

<style scoped lang="scss">
    .wrapper {
        i {
            font-size: 32pt;
            display: inline-block;
            margin-top: 5px;
        }

        .name {
            vertical-align: top;
            display: inline-block;
            margin: 20px 0 0 10px;
        }
    }
</style>