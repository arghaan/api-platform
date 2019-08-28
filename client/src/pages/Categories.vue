<template>
    <div>
        <v-progress-linear
                indeterminate
                v-if="isLoading"
                color="cyan"
        ></v-progress-linear>
        <v-text-field
                v-model="search"
                v-if="!isLoading"
                label="Найти категорию"
                flat
                clearable
                clear-icon="mdi-close-circle-outline"
        ></v-text-field>
        <v-treeview
                ref="tree"
                dense
                :open.sync="open"
                :items="categories"
                :search="search"
                item-key="id"
                item-text="title"
                open-on-click
        >
            <template v-slot:prepend="{ item, open }">
                <v-icon v-if="!item.lastChild">
                    {{ open ? 'mdi-folder-open' : 'mdi-folder-multiple' }}
                </v-icon>
                <v-icon v-else>
                    {{ 'mdi-folder' }}
                </v-icon>
            </template>
            <template v-slot:label="{ item }">
                <div v-if="item.lastChild">
                    {{ item.title }} (id: {{item.categoryId}})
                </div>
                <div v-else>
                    {{ item.title }}
                </div>
            </template>
        </v-treeview>
    </div>
</template>

<script>
    export default {
        name: "Categories",
        data() {
            return {
                search: '',
                open: []
            }
        },
        computed: {
            isLoading() {
                return this.$store.getters['category/isLoading'];
            },
            categories() {
                const cats = this.$store.getters['category/categories'];
                return cats ? cats : [];
            },
        },
        created() {
            if (this.$store.getters['category/categories'] === null) {
                return this.$store.dispatch('category/getCategoryTree')
                    .then(() => {
                        // Out of memory if start search
                        // this.$refs.tree.updateAll(true);
                    });
            }
        }
    }
</script>

<style scoped>

</style>
