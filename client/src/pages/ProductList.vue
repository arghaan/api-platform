<template>
    <v-data-table
            :headers="headers"
            :items="products"
            :server-items-length="total"
            :page.sync="pagination.page"
            :items-per-page.sync="pagination.itemsPerPage"
            :loading="isLoading"
            :disable-sort="true"
            class="elevation-1"
            :footer-props="{
              showFirstLastPage: true,
              itemsPerPageOptions: [10, 50, 100]
            }"

            @pagination="updatePagination"
    >
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-toolbar-title>Argenta Products</v-toolbar-title>
                <v-divider
                        class="mx-4"
                        inset
                        vertical
                ></v-divider>
                <v-spacer></v-spacer>
                <v-dialog v-model="dialog" max-width="500px">
                    <template v-slot:activator="{ on }">
                        <v-btn color="primary" dark class="mb-2" v-on="on">New Item</v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container grid-list-md>
                                <v-layout wrap>
                                    <v-flex xs12>
                                        <v-text-field v-model="editedItem.id" label="ID"></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-text-field v-model="editedItem.name" label="Название"></v-text-field>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                            <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-toolbar>
        </template>
        <template v-slot:item.action="{ item }">
            <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
            >
                edit
            </v-icon>
            <v-icon
                    small
                    @click="deleteItem(item)"
            >
                delete
            </v-icon>
        </template>
    </v-data-table>
</template>

<script>
    export default {
        data: () => ({
            dialog: false,
            headers: [
                {text: 'ID', value: 'id'},
                {text: 'Offer ID', value: 'offer_id'},
                {text: 'Ozon ID', value: 'sku'},
                {text: 'Название', value: 'name',},
                {text: 'Цена', value: 'price'},
                {text: 'Категория', value: 'category_title'},
                {text: 'Действия', value: 'action', sortable: false},
            ],
            editedIndex: -1,
            editedItem: {
                name: '',
                id: 0,
                price: 0,
                category_id: 0,
            },
            defaultItem: {
                name: '',
                id: 0,
                price: 0,
                category_id: 0,
            },
        }),

        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
            },
            isLoading() {
                return this.$store.getters['product/isLoading'];
            },
            hasError() {
                return this.$store.getters['product/hasError'];
            },
            error() {
                return this.$store.getters['product/error'];
            },
            hasProducts() {
                return this.$store.getters['product/hasPosts'];
            },
            products() {
                return this.$store.getters['product/products'];
            },
            total() {
                return this.$store.getters['product/total'];
            },
            pagination() {
                return this.$store.getters['product/pagination'];
            }
        },

        watch: {
            dialog(val) {
                val || this.close()
            },
        },

        created() {
            // this.$store.dispatch('product/fetchCategories');
        },

        methods: {
            editItem(item) {
                this.editedIndex = this.products.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialog = true
            },

            deleteItem(item) {
                const index = this.products.indexOf(item);
                confirm('Are you sure you want to delete this item?') && this.products.splice(index, 1)
            },

            close() {
                this.dialog = false;
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1
                }, 300)
            },

            save() {
                // if (this.editedIndex > -1) {
                //     Object.assign(this.desserts[this.editedIndex], this.editedItem)
                // } else {
                //     this.desserts.push(this.editedItem)
                // }
                // this.close()
            },

            updatePagination(pagination) {
                // console.log(pagination);
                this.$store.dispatch('product/updatePagination', pagination);
            }
        },
    }
</script>
