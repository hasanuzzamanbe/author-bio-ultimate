<template>
    <div class="main-profile-container">
        <el-row class="users_details_row" style="display: flex;">
            <el-col>
               <h3 class="users_details_row_header">Author Basic info:</h3>
            </el-col>
            <el-col style="flex: 1;">
                <el-button type="primary" size="mini">update profile</el-button>
            </el-col>

        </el-row>
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
        <!--socials-->
        <h3 class="users_details_row_header">Author Socials:</h3>

        <el-row class="users_details_row">
            <el-col :sm=22 :lg=12>
               <h4 style="margin-bottom:7px;">Select socials to show frontent:</h4>
                <el-checkbox-group @change="atChange" v-model="socials">
                    <el-checkbox label="Facebook"></el-checkbox>
                    <el-checkbox label="Twitter"></el-checkbox>
                    <el-checkbox label="Linkedin"></el-checkbox>
                </el-checkbox-group>
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

<!--image-->
        <h3 class="users_details_row_header">Author Profile image:</h3>

        <el-row class="users_details_row">
            <el-col>
                <el-radio v-model="useGravatar" label="1">Use Gravatar image</el-radio>
                <el-radio v-model="uploadPic" label="2">Upload image</el-radio>
            </el-col>
            <el-col>
                <h4>Upload your profile picture</h4>
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
            </el-col>
        </el-row>
    </div>
</template>
<script>
export default {
    name: 'MyProfile',
    data() {
        return {
            authorDetails: {
                name: '',
                email: '',
                facebook: '',
                twitter: '',
                linkedin:'',
            },
            useGravatar:'',
            uploadPic: '',
            uploadUrl:'',
            profile:{
              image: ''
            },
            socials: [],
            isShow: {
                facebook: false,
                twitter: false,
                linkedin: false,
            }
        }
    },
    methods: {
        atChange(e) {
            this.isShow = {
                facebook: false,
                twitter: false,
                linkedin: false,
            }
            if(this.socials.includes('Facebook')){
                this.isShow.facebook = true
            }
            if(this.socials.includes('Twitter')){
                this.isShow.twitter = true
            }
            if(this.socials.includes('Linkedin')){
                this.isShow.linkedin = true
            }

            // authorDetails.socials.includes('facebook')
        },
        handleUploadSuccess(response) {
            this.profile.image = response.data.file.url;
        },
        handleUploadError(error) {
            this.$message.error(error.toString());
        },
    }
}
</script>
<style lang="scss">
    .main-profile-container{
        padding: 36px;
    }
    .users_details_row{
        margin-top:12px;
        &_header {
            margin-top:23px;
            text-decoration: underline;
         }
        .avatar-uploader {
            font-size: 47px;
        }
    }


</style>

