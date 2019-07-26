<template>
    <v-menu offset-y class="wrapper">
        <template v-slot:activator="{ on }">
            <i v-if="avatar === ''" class="material-icons" v-on="on">
                account_circle
            </i>
            <span v-if="name !== ''" class="name">{{name}}</span>
        </template>
        <v-list>
            <v-list-item>
                <v-list-item-title>Login</v-list-item-title>
            </v-list-item>
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
