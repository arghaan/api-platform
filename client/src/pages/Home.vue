<template>
    <v-layout column>
        <v-progress-linear
                indeterminate
                v-if="isLoading"
                color="cyan"
        ></v-progress-linear>
        <v-alert
                v-model="alert"
                :type="alertType"
                class="mb-4"
                outlined
        >
            {{ alertMessage }}
        </v-alert>
        <h2 class="mb-12">Download from marketplace</h2>
        <v-form
                ref="form"
        >
            <v-btn
                    color="info"
                    @click="getCategories"
                    :disabled="isLoading"
                    class="mr-3"
            >
                Categories
            </v-btn>
            <v-btn
                    color="info"
                    @click="getProducts"
                    :disabled="isLoading"
                    class="mr-3"
            >
                Products
            </v-btn>
        </v-form>
    </v-layout>
</template>

<script>

    export default {
        name: "Home",
        data() {
            return {
                top: true,
                alert: false,
                alertType: 'success',
                timeout: 3000,
            }
        },
        computed: {
            isLoading() {
                return this.$store.getters['category/isLoading'];
            },
            alertMessage() {
                const message = this.$store.getters['category/message'];
                if (message) {
                    if (message.status && message.status === 200) {
                        this.alertType = 'success';
                        this.alert = true;
                        return `Successfully downloaded ${message.data} categories.`;
                    } else {
                        this.alertType = 'error';
                        this.alert = true;
                        return message;
                    }
                }
                return message;
            }
        },
        methods: {
            getCategories() {
                this.alert = false;
                return this.$store.dispatch('category/downloadCategories');
            },
            getProducts() {
                this.alert = false;
                return this.$store.dispatch('product/downloadProducts');
            }
        }
    }
</script>

<style scoped>

</style>
