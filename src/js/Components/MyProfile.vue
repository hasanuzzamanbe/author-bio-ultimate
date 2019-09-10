<template>
    <div class="main-profile-container">
        <el-row class="update_button_row">
            <el-col>
                <el-button type="primary" size="mini" @click="update">update profile</el-button>
            </el-col>
        </el-row>
        <el-row class="users_details_row">
            <el-col>
                <h3 class="users_details_row_header">Author Basic info:</h3>
            </el-col>
        </el-row>
        <div class="inner_box">
            <el-row class="users_details_row">
                <el-col :sm=22 :lg=12>
                    <span class="users_name_label"><strong>Full Name*</strong></span>
                    <el-input
                            placeholder="Input Your Name"
                            v-model="authorDetails.name"
                            size="small"
                    ></el-input>
                </el-col>
            </el-row>

            <el-row class="users_details_row">
                <el-col :sm=22 :lg=12>
                    <span class="users_name_label"><strong>Email Address*</strong></span>
                    <el-input
                            placeholder="Input Your email address"
                            v-model="authorDetails.email"
                            size="small"
                    ></el-input>
                </el-col>
            </el-row>
            <el-row class="users_details_row">
                <el-col :sm=22 :lg=12>
                    <span class="users_designation_label"><strong>Your Designation*</strong></span>
                    <el-input
                            placeholder="Input your designation"
                            v-model="authorDetails.designation"
                            size="small"
                    ></el-input>
                </el-col>
            </el-row>
        </div>

        <h3 class="users_details_row_header"> Author Bio Details:
            <el-tooltip class="item" placement="bottom-start" effect="light">
                <div slot="content">
                    <p>
                        You can use your bio which is already
                        <br>
                        updated on your user profile page.
                        Or Add new bio using editor.
                    </p>
                </div>
                <i style="float: right;" class="el-icon-info el-text-info"/>
            </el-tooltip>
        </h3>
        <div class="inner_box">

            <el-row>
                <el-col :span="12">
                    <el-radio default v-model="authorDetails.useBioFrom" label="userProfileBio">Use bio from user
                        profile
                    </el-radio>
                    <el-radio v-model="authorDetails.useBioFrom" label="newAddedBio">Update your bio with Editor
                    </el-radio>
                </el-col>
            </el-row>
            <el-row v-if="authorDetails.useBioFrom ==='newAddedBio'" class="users_details_row" :rules="rules">
                <el-col :sm=22 :lg=12>
                    <span class="users_bio_label"><strong>Your Bio Data Here</strong></span>

                    <div prop="email_body" label="Author bio">
                        <wp-editor
                                :editor_id="'wp_email_editor_'"
                                v-model="authorDetails.bio"
                        />
                    </div>
                </el-col>
            </el-row>
            <el-row class="users_details_row" v-else>
                <el-col :sm=22 :lg=12>
                    <el-input
                            type="textarea"
                            :rows=4
                            disabled
                            v-model="bioFromUser">
                    </el-input>
                </el-col>
            </el-row>
        </div>

        <!--socials-->
        <h3 class="users_details_row_header"> Author Socials:
            <el-tooltip class="item" placement="bottom-start" effect="light">
                <div slot="content">
                    <p>
                        Select socials to show frontent, and put your profile link.
                    </p>
                </div>
                <i style="float: right;" class="el-icon-info el-text-info"/>
            </el-tooltip>
        </h3>

        <!--<h4>Select socials to show frontent:</h4>-->
        <div class="inner_box">
            <el-row class="users_details_row">
                <el-col :sm=22 :lg=12>
                        <el-checkbox v-model="isShow.facebook" true-label="true" label="Facebook"></el-checkbox>
                        <el-checkbox v-model="isShow.twitter" true-label="true" label="Twitter"></el-checkbox>
                        <el-checkbox v-model="isShow.linkedin" true-label="true" label="Linkedin"></el-checkbox>
                </el-col>
            </el-row>

            <el-row class="users_details_row" v-if="isShow.facebook">
                <el-col :sm=22 :lg=12>
                    <span class="users_name_label"><strong>Facebook</strong></span>
                    <el-input
                            placeholder="Your facebook profile link"
                            v-model="authorDetails.facebook"
                            size="small"
                    ></el-input>
                </el-col>
            </el-row>
            <el-row class="users_details_row" v-if="isShow.twitter">
                <el-col :sm=22 :lg=12>
                    <span class="users_name_label"><strong>Twitter</strong></span>
                    <el-input
                            placeholder="Your twitter profile link"
                            v-model="authorDetails.twitter"
                            size="small"
                    ></el-input>
                </el-col>
            </el-row>
            <el-row class="users_details_row" v-if="isShow.linkedin">
                <el-col :sm=22 :lg=12>
                    <span class="users_name_label"><strong>Linkedin</strong></span>
                    <el-input
                            placeholder="Your linkedin profile link"
                            v-model="authorDetails.linkedin"
                            size="small"
                    ></el-input>
                </el-col>
            </el-row>
        </div>
        <!--image-->
        <h3 class="users_details_row_header">Author Profile image:
            <el-tooltip class="item" placement="bottom-start" effect="light">
                <div slot="content">
                    <p>
                        use gravatar image: will show your profile image from gravatar.<br>
                        or you can upload your own.
                    </p>
                </div>
                <i style="float: right;" class="el-icon-info el-text-info"/>
            </el-tooltip>
        </h3>
        <div class="inner_box">
            <el-row>
                <el-col :span="12">
                    <el-radio v-model="imageFrom" label="gravatar">Use Gravatar image</el-radio>
                    <el-radio v-model="imageFrom" label="upload">Upload image</el-radio>
                </el-col>
            </el-row>


            <el-row class="users_details_row">

                <el-col :span="8" v-if="imageFrom === 'upload'" class="uploadPane">
                    <el-upload
                            class="avatar-uploader"
                            :action="uploadUrl"
                            :show-file-list="false"
                            accept_x="image/png, image/jpeg"
                            :on-error="handleUploadError"
                            :on-success="handleUploadSuccess"
                    >
                        <img
                                v-if="profile.image"
                                :src="profile.image"
                                class="avatar"
                        />
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                    <h4>Upload your profile picture</h4>
                </el-col>

                <el-col :span="8" v-if="imageFrom === 'gravatar'">
                    <img :src="profile.gravatar" alt="profile pic not loaded">
                    <br>
                    <p>NB: Be sure, your email address has gravatar.
                        also You can change your profile picture on
                        <a href="https://en.gravatar.com" target="_blank">Gravatar</a>.</p>
                </el-col>
            </el-row>
        </div>
    </div>
</template>
<script>
    import wpEditor from '../components/Common/_wp_editor';
    import popover from '../components/Common/input-popover-dropdown.vue'

    export default {
        name: 'MyProfile',
        components: {
            wpEditor,
            popover
        },
        data() {
            return {
                rules: {
                    email_body: [
                        {
                            required: true, message: 'Please Provide Notification Title',
                        }
                    ]
                },
                bioFromUser: window.authorBioAdmin.author_des,
                authorDetails: {
                    authorId: null,
                    name: '',
                    email: '',
                    designation: '',
                    bio: 'Please update your Bio',
                    facebook: '',
                    twitter: '',
                    linkedin: '',
                    useBioFrom: 'userProfileBio',
                },
                imageFrom: 'gravatar',
                uploadPic: '',
                uploadUrl: window.authorBioAdmin.image_upload_url,
                profile: {
                    image: '',
                    gravatar: window.authorBioAdmin.avatar
                },
                isShow: {
                    facebook: true,
                    twitter: true,
                    linkedin: true,
                }
            }
        },
        methods: {
            update() {
                this.authorDetails.imageFrom = this.imageFrom
                this.authorDetails.profile = this.profile

                this.$adminPost({
                    data: this.authorDetails,
                    socials: this.isShow,
                    imageFrom: this.imageFrom,
                    action: "author_bio_admin_ajax",
                    route: "add_bio"
                })
            },
            handleUploadSuccess(response) {
                this.profile.image = response.data.file.url;
            },
            handleUploadError(error) {
                this.$message.error(error.toString());
            },
        },
        mounted() {
            this.$adminGet({
                route: "get_bio"
            }).then((res) => {
                if(res.data.data){
                        this.isShow= res.data.socials
                        this.authorDetails.authorId = res.data.data.author_id,
                        this.authorDetails.name = res.data.data.author_name,
                        this.authorDetails.email = res.data.data.author_email,
                        this.authorDetails.designation = res.data.data.author_designation,
                        this.authorDetails.bio = res.data.bio,
                        this.authorDetails.facebook = res.data.data.author_fb,
                        this.authorDetails.twitter = res.data.data.author_tw,
                        this.authorDetails.linkedin = res.data.data.author_ln,
                        this.authorDetails.useBioFrom = res.data.data.useBioFrom,
                        this.profile.image = res.data.data.author_img
                        this.imageFrom = res.data.imageFrom
                }

            })
        }
    }
</script>
<style lang="scss">
    .main-profile-container {
        padding: 36px;

        .inner_box {
            background: #ffffff87;
            padding: 23px;
            border: 1px solid #cec6c64d;
        }

        .update_button_row {
            text-align: right;
            margin-bottom: -13px;
            margin-top: -28px;
        }
    }

    .users_details_row {
        margin-top: 12px;

        &_header {
            margin-top: 23px;
            background: #7c787833;
            padding: 7px 23px;
            margin-bottom: 0px;
        }

        .avatar-uploader {
            font-size: 47px;
        }

        .avatar-uploader .el-upload {
            border: 1px dashed #d9d9d9;
            border-radius: 6px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .avatar-uploader .el-upload:hover {
            border-color: #409EFF;
        }

        .avatar-uploader-icon {
            font-size: 28px;
            color: #8c939d;
            width: 178px;
            height: 178px;
            line-height: 178px;
            text-align: center;
        }

        .avatar {
            width: 178px;
            height: 178px;
            display: block;
        }
    }


</style>

