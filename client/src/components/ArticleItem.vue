<template>
    <v-card
            class="mx-auto"
            color="#00F"
            dark
            max-width="400"
    >
        <v-card-title>
            <span class="title font-weight-light">{{item.title + (index + 1)}}</span>
        </v-card-title>

        <v-card-text class="headline font-weight-bold">
            {{articleShort}}
        </v-card-text>
        <v-card-actions>
            <v-list-tile class="grow">
                <v-list-tile-avatar color="grey darken-3">
                    <v-icon>avatar</v-icon>
                </v-list-tile-avatar>

                <v-list-tile-content>
                    <v-list-tile-title>{{item.author}}</v-list-tile-title>
                </v-list-tile-content>

                <v-layout
                        align-center
                        justify-end
                >
                    <v-icon class="mr-1">mdi-heart</v-icon>
                    <span class="subheading mr-2">256</span>
                    <span class="mr-1">·</span>
                    <v-icon class="mr-1">mdi-share-variant</v-icon>
                    <span class="subheading">45</span>
                </v-layout>
            </v-list-tile>
        </v-card-actions>
    </v-card>
</template>

<script>
    import _ from 'lodash'

    export default {
        name: "ArticleItem",
        props: {
            item: Object,
            index: Number
        },
        computed: {
            articleShort() {
                return _.truncate(this.item.text, {'length': 200})
            }
        }
    }
</script>

<style scoped>

</style>