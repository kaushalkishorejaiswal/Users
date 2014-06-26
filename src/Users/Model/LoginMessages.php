<?php
namespace Users\Model;

interface LoginMessages
{

    const INVALID_USER_PASSWORD = 'Invalid Email and Password.';

    const LOGIN_LOCKED = 'Your account is temporary locked because of too many incorrect login attempts. Please reset your password using forgot password link.';

    const ACCOUNT_NOT_ACTIVE = 'Your account is not active. Contact your System Administrator.';

    const NOT_LOGIN_ACCESS = 'Please login to continue';

    const PASS_CHANGED_SUCCESS = 'Your password was changed successfully.';

    const INVALID_OLD_PASS = 'Your old password is not valid.';

    const RESET_SUCCESS_MESSAGE = 'Check your email for more details.';

    const EMAIL_NOT_EXIST = 'Email does not exist. Please try again.';

    const RESET_TOKEN_EXPIRED = 'Your password has expired. Please try again.';

    const PASS_UPDATE_SUCCESS = 'Your password was updated successfully.';

    const PASS_CHANGE_ERROR = 'Your password could not be updated. Please contact your System Administrator.';

    const SELECT_ROLE_MESSAGE = 'Please select role';

    const PASS_CHANGE_ROLE = "Your role changed successfully.";

    const PASS_SAME = "Your old and new password cannot be same.";

    const ACCOUNT_EXPIRED = "Your licence has been expired. Kindly contact to complysight team.";

    const NO_ROLES = "You do not have any role. Please contact to your System Adminstrator.";

    const CSRF_ERROR = "The form submitted did not originate from the expected site.";
}
