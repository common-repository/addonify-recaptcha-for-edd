var currentTime = Date.now();

var captchaEle;

// Addonify Recaptcha Object Initialization.
var addonifyRecaptcha = {

	createRecaptchaEle: function () {
		// Get login form element.
		loginForm = document.getElementById('edd_login_form');
		// Get register form element.
		registerForm = document.getElementById('edd_register_form');

		// If loginForm isn't "undefined" and loginForm isn't "null", then loginForm exists.
		if (typeof (loginForm) != 'undefined' && loginForm != null) {
			// Check if reCaptcha should be displayed.
			if (addonifyRecaptchaArgs.showRecaptchaInLogin == '1') {
				// Create an paragraph for recaptcha element.
				captchaEle = document.createElement('p');
				// Set id attribute to the recaptcha element.
				captchaEle.setAttribute("id", "addonify-g-recaptcha-" + currentTime);
				// Get the element before which the recaptcha element is to be inserted.
				var target = document.querySelector('#edd_login_form p.edd-login-remember');
				// Insert recaptcha element before the target element.
				target.parentNode.insertBefore(captchaEle, target);
			}
		}

		// If registerForm isn't "undefined" and registerForm isn't "null", then registerForm exists.
		if (typeof (registerForm) != 'undefined' && registerForm != null) {
			// Check if reCaptcha should be displayed.
			if (addonifyRecaptchaArgs.showRecaptchaInRegister == '1') {
				// Create an paragraph for recaptcha element.
				captchaEle = document.getElementById('addonify-g-recaptcha');
				// Set id attribute to the recaptcha element.
				captchaEle.setAttribute("id", "addonify-g-recaptcha-" + currentTime);
			}
		}

	},
}

addonifyRecaptcha.createRecaptchaEle();

var onloadCallback = function () {

	if (captchaEle != null) {
		grecaptcha.render(captchaEle, {
			'sitekey': addonifyRecaptchaArgs.clientSecreteKey
		});
	}
};