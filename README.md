Users module is a ZF2 module, which provides all the users login and authentication process. Such as login, remember me, forgot password etc.

<h3>Functionality of the Users Module:</h3>
<ul>
<li>User Login Authentication</li>
<li>Change Password</li>
<li>Remember Me Functionality</li>
<li>Reset Password</li>
<li>Forgot Password</li>
<li>Forgot Password Mail Functionality</li>
</ul>

<h3>How to Install:</h3>
<ul>
<li>Clone the Users Module</li>
<li>Import the Users.sql file in your database</li>
<li>Copy the users.local.php.dist in your config/autoload folder</li>
<li>Rename it to users.local.php</li>
<li>Modify the settings of users.local.php according to you</li>
</ul>


<h3>Routes of the Actions:</h3>
<ul>
<li>Login : /users</li>
<li>Login : /users/index</li>
<li>Logout : /users/logout</li>
<li>Forgot Password : /users/forgot-password</li>
<li>Reset Password : /users/reset-password</li>
<li>Change Password : /users/change-password</li>
</ul>


<h3>Database Table Installation:</h3>
```mysql
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(101) NOT NULL,
  `password` varchar(45) NOT NULL,
  `login_attempts` int(11) NOT NULL DEFAULT '0',
  `login_attempt_time` int(11) NOT NULL DEFAULT '0',
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `last_signed_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) 

INSERT INTO `users` (`id`, `email`, `password`, `login_attempts`, `login_attempt_time`, `first_name`, `last_name`, `status`, `last_signed_in`) VALUES (1, 'kaushal.rahuljaiswal@gmail.com', 'd4cb903787695a544172af6f0af88fef583a81c8', 0, 0, '', '', 'Active', NULL);
```
<h3>Default Credentials</h3>
<ul>
<li>Email : kaushal.rahuljaiswal@gmail.com</li>
<li>Password : Kaushal@123</li>
</ul>
