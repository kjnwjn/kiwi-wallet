<di class="text-center">
    <h2>LOGIN PAGE</h2>
</di>
<style>
    .form-validation .error-message {
        color: red;
        margin-top: 12px;
        font-size: 12px;
    }
</style>
<div class="main">
    <form action="" method="POST" class="form" id="Login">
        <h3 class="heading">Login</h3>
        <p class="desc"></p>
        <div class="spacer"></div>
        <div class="form-group form-validation">
            <label for="username" class="form-label">Username</label>
            <input id="username" name="username" placeholder="Username" type="text" class="form-control" rules="required" />
            <span class="error-message"></span>
        </div>
        <div class="form-group form-validation">
            <label for="password" class="form-label">password</label>
            <input id="password" name="password" placeholder="Type 6 characters" type="password" class="form-control" rules="required&min=6" />
            <span class="error-message"></span>
        </div>
        <button type="submit" id="btnSubmit" class="form-submit btn">Đăng ký</button>
    </form>
</div>