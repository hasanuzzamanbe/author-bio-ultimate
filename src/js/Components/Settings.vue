<template>

    <div class="main-profile-container">
        <el-row class="update_button_row">
            <el-col>
                <el-button type="primary" size="mini" @click="update">update settings</el-button>
            </el-col>
        </el-row>
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
                    <el-radio class="template_radio" v-model="useTemp" label="template1">Template 1</el-radio>
                    <img :src="assets_url + 'admin/templates/template1.png'"/>
                </el-col>
                <el-col class="inner_column" :sm=22 :lg=10>
                    <el-radio class="template_radio" v-model="useTemp" label="template2">Template 2</el-radio>
                    <img :src="assets_url + 'admin/templates/template2.png'"/>
                </el-col>
            </el-row>
            <el-row class="users_template_row">
                <el-col class="inner_column" :sm=22 :lg=10>
                    <el-radio class="template_radio" v-model="useTemp" label="template3">Template 3</el-radio>
                    <img :src="assets_url + 'admin/templates/template3.png'"/>
                </el-col>
            </el-row>
        </div>


        <el-row class="users_details_row">
            <el-col>
                <h3 class="users_details_row_header">Recent Post Settings:</h3>
            </el-col>
        </el-row>
        <div class="inner_box">
            <el-row class="users_template_row">
            </el-row>
            <el-row class="users_template_row" :gutter="20">
                <el-col class="inner_column" :sm=22 :lg=10>
                    <el-radio class="template_radio" v-model="useTemp" label="template1">Template 1</el-radio>
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
                useTemp: 'template2'
            }
        },
        methods: {
            update() {
                this.$adminPost({
                    data: this.useTemp,
                    action: "author_bio_admin_ajax",
                    route: "update_settings"
                }).then(
                    this.$message({
                        showClose: true,
                        message: 'Congrats, Data updated successfully',
                        type: 'success'
                    })
                )
            }
        },
        mounted() {
            this.$adminGet({
                route: "get_settings"
            }).then((res) => {
                this.useTemp = res.data.template;
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

