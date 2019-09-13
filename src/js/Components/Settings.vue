<template>

    <div class="main-profile-container">
        <el-row class="update_button_row">
            <el-col>
                <el-button type="primary" size="mini" @click="update">update settings</el-button>
            </el-col>
        </el-row>

        <el-row class="users_details_row">
            <el-col>
                <h3 class="users_details_row_header">Recent Post Settings:</h3>
            </el-col>
        </el-row>
        <div class="inner_box">
            <el-row class="users_template_row" :gutter="20">
                <el-col class="inner_column" :sm=22 :lg=10>
                    <el-checkbox v-model="settings.recentPost" true-label="enabled" label="Show recent Posts By author"></el-checkbox>
                </el-col>
            </el-row>
            <el-row v-if="this.settings.recentPost === 'enabled'" class="users_template_row" :gutter="20" style="margin-top:23px;">
                <el-col class="inner_column" :sm=22 :lg=10>
                    <strong><p class="demo-input-label">How many post you want to show in recent?</p></strong><br>
                </el-col>
                <el-col class="inner_column" :sm=22 :lg=10>
                    <el-input-number size="mini" v-model="settings.postCount"  :min="1" :max="20"></el-input-number>
                </el-col>

            </el-row>
            <el-row class="users_template_row" :gutter="20" style="margin-top:23px">
                <el-col class="inner_column" :sm=22 :lg=10>
                    <strong><p style="margin-top: 0px;" class="demo-input-label">Choose a recent post template type:</p></strong><br>
                </el-col>
                <el-col class="inner_column" :sm=22 :lg=10>
                    <el-radio class="recent_type_radio" v-model="settings.recentType" label="image">Title with Image</el-radio>
                    <el-radio class="recent_type_radio" v-model="settings.recentType" label="titleonly">Title only</el-radio>
                </el-col>
            </el-row>
        </div>

        <el-row class="users_details_row">
            <el-col>
                <h3 class="users_details_row_header">Exclude Author Bio For Specefic Post:</h3>
            </el-col>
        </el-row>
        <div class="inner_box">
            <el-row class="users_template_row" :gutter="20" style="margin-top:23px;">
                <el-col class="inner_column" :sm=22 :lg=10>
                    <strong><span class="demo-input-label">Enter post Id to exclude author bio from post.
                        <br>For multiple post use comma as seperator:</span></strong><br>
                    <el-input
                            placeholder="1,2,3...."
                            v-model="settings.excludes"
                            >
                    </el-input>
                </el-col>
            </el-row>
        </div>


        <el-row class="users_details_row">
            <el-col>
                <h3 class="users_details_row_header">Social Icon Templates:</h3>
            </el-col>
        </el-row>
        <div class="inner_box">
            <el-row class="users_template_row">
            </el-row>
            <el-row class="users_template_row" :gutter="20">
                <el-col class="inner_column" :sm=22 :lg=10>
                    <el-radio class="template_radio" v-model="settings.useTemp" label="template1">Template 1</el-radio>
                    <img :src="assets_url + 'admin/templates/template1.png'"/>
                </el-col>
                <el-col class="inner_column" :sm=22 :lg=10>
                    <el-radio class="template_radio" v-model="settings.useTemp" label="template2">Template 2</el-radio>
                    <img :src="assets_url + 'admin/templates/template2.png'"/>
                </el-col>
            </el-row>
            <el-row class="users_template_row">
                <el-col class="inner_column" :sm=22 :lg=10>
                    <el-radio class="template_radio" v-model="settings.useTemp" label="template3">Template 3</el-radio>
                    <img :src="assets_url + 'admin/templates/template3.png'"/>
                </el-col>
            </el-row>
        </div>

    </div>
</template>
<script>
    export default {
        name: 'Settings',
        data() {
            return {
                assets_url: window.authorBioAdmin.assets_url,
                settings: {
                    useTemp: 'template2',
                    recentPost: 'enabled',
                    postCount: 3,
                    excludes: '',
                    recentType:''
                }
            }
        },
        methods: {
            update() {
                this.settings.excludesArray =  this.settings.excludes.split(',');
                this.$adminPost({
                    data: this.settings,
                    action: "author_bio_admin_ajax",
                    route: "update_settings"
                }).then(
                    this.$message({
                        showClose: true,
                        message: 'Congrats, Settings updated successfully',
                        type: 'success'
                    })
                )
            }
        },
        mounted() {
            this.$adminGet({
                route: "get_settings"
            }).then((res) => {
                    this.settings = res.data.settings;
            })
        }
    }
</script>
<style lang="scss">
    .users_template_row {
        .inner_column {
            position: relative;
        }

        .template_radio {
            position: absolute;
            top: 21px;
            right: 0px;
        }

        img {
            margin-bottom: 10px;
            max-width: 100%;
            border: 4px solid silver;
        }

    }

</style>

