<template>
    <div class="chat-container">
        <div class="left">
            <table>
                <tr>
                    <td class="message-window">
                        <div class="message" v-for="message in messages">
                            <div class="time">{{ message.created_at }}</div>
                            <div class="content">{{ message.message }}</div>
                        </div>asdf
                    </td>
                    <td class="members">
                        <ul>
                            <li v-for="user in users">{{ user.name }}</li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
        <div class="type-area">
            <input type="text" v-model="message"/>
            <button type="submit" @click="send">Send</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                messages : [],
                users : [],
                message: ''
            }
        },

        mounted() {
            this.listen();

            this.getTasks();
        },

        methods : {
            listen() {
                window.Echo.join('messages')
                    .here(users => {
                        this.users = users;
                    })
                    .joining(user => {
                        if (! this.inArray(user)) {
                            this.users.push(user);
                        }
                    })
                    .listen('MessageCreated', event => {
                        this.messages.push(event.message);
                    });
            },

            inArray(user) {
                for(var i = 0, len = this.users.length; i < len; i++) {
                    if (this.users[i].name === user.name) {
                        return true;
                    }
                }

                return false;
            },

            getTasks() {
                window.axios.get('http://socialite.dev/api/messages')
                    .then(response => {
                        this.messages = response.data;
                    });
            },

            send() {
                window.axios.post('http://socialite.dev/api/messages', {
                    'message' : this.message })
                    .then(() => {
                        this.message = '';
                    });
            }
        }
    }
</script>

<style>
    .chat-container {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        border: 1px solid black
    }

    ul {
        padding: 0;
    }

    li {
        list-style: none;
    }

    .left {
        width: 100%;
        border-bottom: 1px solid black;
    }

    .message-window {
        width: 100%;
        padding: 10px;
    }

    .members {
        padding: 10px;
        vertical-align: top;
        border-left: 1px solid black;
    }

    .message {
        display: flex;
        justify-content: flex-start;
    }

    .type-area {
        padding: 10px;
    }

    .time {
        font-size: 11px;
        font-style: italic;
        padding-right: 10px;
    }

    .content {
        text-align: left;
        font-size: 15px;
        font-weight: bolder;
    }
</style>
