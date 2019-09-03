<template>
    <div class="main-profile-container">
        <el-form>

            <el-form-item label="Full Name *">
                <el-input
                        placeholder="Input Your Name"
                        v-model="authorDetails.input"
                        size="small"
                ></el-input>
            </el-form-item>
            <el-button type="primary">click</el-button>
            <el-form-item label="Full Name *">
                <el-input
                        placeholder="Input Your Name"
                        v-model="authorDetails.email"
                        size="small"
                ></el-input>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'Charts',
    data() {
        return {
            authorDetails: {
                input: ''
            }
        }
    }
}
</script>
<style>
    .main-profile-container{
        margin-top:67px;
    }

</style>

