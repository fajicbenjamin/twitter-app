<template>
    <popover :name="user.screen_name" event="hover">
        <div class="popover-user">
            <vs-avatar size="large" class="avatar" :src="user.profile_image_url"/>
            <div class="user-identity">
                <h5>
                    {{ user.name }}
                </h5>
                <h6>
                    <a :href="`https://twitter.com/${user.screen_name}`">
                        @{{ user.screen_name }}
                    </a>
                </h6>
            </div>
            <div class="description" v-html="user.description"></div>
            <div class="followers">
                    <span>
                        <strong>{{ formatFollowerNumbers(user.friends_count) }}</strong> following
                    </span>
                <span>
                        <strong>{{ formatFollowerNumbers(user.followers_count) }} </strong> followers
                    </span>
            </div>
        </div>
    </popover>
</template>

<script>
    export default {
        props: {
            user: {
                type: Object,
                default: null
            }
        },
        methods: {
            formatFollowerNumbers(number) {
                let si = [
                    { value: 1, symbol: "" },
                    { value: 1E3, symbol: "k" },
                    { value: 1E6, symbol: "M" },
                    { value: 1E9, symbol: "G" },
                    { value: 1E12, symbol: "T" },
                    { value: 1E15, symbol: "P" },
                    { value: 1E18, symbol: "E" }
                ];
                let rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
                let i;
                for (i = si.length - 1; i > 0; i--) {
                    if (number >= si[i].value) {
                        break;
                    }
                }
                return (number / si[i].value).toFixed(1).replace(rx, "$1") + si[i].symbol;
            },
            formatDescription() {
                if (this.user && this.user.entities && this.user.entities.description && this.user.entities.description.urls) {
                    this.user.entities.description.urls.forEach(url => {
                        this.user.description = this.user.description.replace(url.url, `<a href="${url.extended_url}">${url.display_url}</a>`)
                    })
                    //TODO tagged usernames in description
                }
            }
        },
        created() {
            this.formatDescription()
        }
    }
</script>

<style scoped>
    .popover-user {
        display: flex;
        flex-direction: column;
        padding: 10px;
    }

    .user-identity {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .user-identity h6, .user-identity h5 {
        margin: 0
    }

    .followers {
        display: flex;
    }

    .followers span:first-child {
        margin-right: 20px;
    }

    .description {
        margin: 10px 0;
    }
</style>