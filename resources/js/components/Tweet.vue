<template>
    <div>
        <profile-popover :user="tweet.user"></profile-popover>
        <vs-card>
            <div slot="header">
                <div class="user-row">
                    <vs-avatar size="large" class="avatar" :src="tweet.user.profile_image_url"/>
                    <div class="user-identity" v-popover="{ name: tweet.user.screen_name }">
                        <h5>
                            {{ tweet.user.name }}
                        </h5>
                        <h6>
                            <a :href="`https://twitter.com/${tweet.user.screen_name}`">
                                @{{ tweet.user.screen_name }}
                            </a>
                        </h6>
                    </div>
                </div>
            </div>
            <div class="tweet-text-div">
                <p class="in-reply" v-if="tweet.in_reply_to_screen_name" v-html="replyingTo"></p>
                <p class="in-reply" v-if="tweetData.retweeted_status">
                    <vs-icon icon="cached"></vs-icon> {{ tweetData.user.name }} retweeted
                </p>
                <p class="tweet-text" v-html="tweet.text"></p>
                <div class="image-container" v-if="media">
                    <img class="tweet-image" :src="image" alt="">
                </div>
                <div v-if="tweet.is_quote_status">
                    <tweet :tweet-data="tweet.quoted_status"></tweet>
                </div>
            </div>
            <div slot="footer">
                <vs-row vs-justify="space-evenly">
                    <span class="social-counters">
                        <vs-icon icon="cached"></vs-icon> {{ tweet.retweet_count }}
                    </span>
                    <span class="social-counters">
                        <vs-icon icon="favorite_border"></vs-icon> {{ tweet.favorite_count }}
                    </span>
                </vs-row>
            </div>
        </vs-card>
    </div>
</template>

<script>
    export default {
        props: {
            tweetData: {
                type: Object,
                default: null
            }
        },
        data: function () {
            return {
                tweet: this.tweetData,
                media: false,
                image: null,
                is_quote: false,
            }
        },
        computed: {
          replyingTo() {
              if (this.tweet && this.tweet.in_reply_to_screen_name) {
                  return `replying to <a href="https://twitter.com/${this.tweet.in_reply_to_screen_name}/status/${this.tweet.in_reply_to_status_id_str}">@${this.tweet.in_reply_to_screen_name}</a>`
              }

              return ''
          }
        },
        methods: {
            userMentions() {
                if (this.tweet.entities && this.tweet.entities.user_mentions) {
                    this.tweet.entities.user_mentions.forEach(mention => {
                        this.tweet.text = this.tweet.text.replace(`@${mention.screen_name}`, `<a href="https://twitter.com/${mention.screen_name}">@${mention.screen_name}</a>`)
                    })
                }
            },
            handleMedia() {
                if (this.tweet.entities && this.tweet.entities.media) {
                    this.media = true
                    this.image = this.tweet.entities.media[0].media_url

                    this.tweet.text = this.tweet.text.slice(0, this.tweet.entities.media[0].indices[0])
                        + this.tweet.text.slice(this.tweet.entities.media[0].indices[1])
                }
            },
            handleReply() {
                if (this.tweet.in_reply_to_screen_name) {
                    this.tweet.text = this.tweet.text.substr(this.tweet.in_reply_to_screen_name.length + 1)
                }
            },
            handleRetweetedStatus() {
                if (this.tweet.retweeted_status) {
                    this.tweet = this.tweet.retweeted_status
                }
            },
            handleUrls() {
                if (this.tweet.entities && this.tweet.entities.urls) {
                    this.tweet.entities.urls.forEach(url => {
                        if (this.tweet.quoted_status && url.expanded_url.substr(url.expanded_url.lastIndexOf('/') + 1) === this.tweet.quoted_status.id_str)
                            this.tweet.text = this.tweet.text.replace(url.url, '')
                        this.tweet.text = this.tweet.text.replace(url.url, `<a href="${url.expanded_url}">${url.display_url}</a>`)
                    })
                }
            },
            profileHover(user) {
                return `<vs-avatar size="large" class="avatar" src="${user.profile_image_url}"/>`
            }
        },
        created() {
            // console.log(this.tweet)
            if (this.tweet) {
                this.handleRetweetedStatus()
                this.handleUrls()
                // this.handleReply()
                // this.userMentions()
                this.handleMedia()
            }
        }
    }
</script>

<style scoped>
    .user-row {
        display: flex;
    }

    .user-identity {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .user-identity h6, .user-identity h5 {
        margin: 0
    }

    .tweet-text-div {
        cursor: pointer;
    }

    .tweet-text {
        font-size: 16px;
        overflow-wrap: break-word;
    }

    .image-container {
        height: 280px;
    }

    .tweet-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px
    }

    .in-reply {
        color: grey;
        display: flex;
        align-items: center;
    }

    .social-counters {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .vs-icon {
        font-size: 1rem;
        margin-right: 2px;
    }

    .vue-popover {
        width: 300px!important;
    }
</style>