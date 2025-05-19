function validateRegister() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

      
            if (!name && !email && !password) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Name, Email, and Password must be filled out.',
                });
                return false;
            }
            if (!name && !password) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Name and Password must be filled out.',
                });
                return false;
            }
            if (!email && !password) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: ' Email and Password must be filled out.',
                });
                return false;
            }
            if (!name && !email ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Name and Email must be filled out.',
                });
                return false;
            }
            if (!name) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Name must be filled out.',
                });
                return false;
            }
            if (!email) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Email must be filled out.',
                });
                return false;
            }
            if (!/\S+@\S+\.\S+$/.test(email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Email',
                    text: 'Please provide a valid email address.',
                });
                return false;
            }

            if (!password) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Password must be filled out.',
                });
                return false;
            }

            // if (password.length < 8) {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Invalid Password',
            //         text: 'Password must be 8 characters or fewer.',
            //     });
            //     return false;
            // }
            if (/\s/.test(password)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Password',
                    text: 'Password cannot contain spaces.',
                });
                return false;
    }

            return true;
        }


 function validateLogin() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
           
        
            if (!email && !password) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Email and Password must be filled out.',
                });
                return false;
            }
            if (!email) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Email must be filled out.',
                });
                return false;
            }

            if (!email.includes('@')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Email',
                    text: 'Please include "@" in your email address.',
                });
                return false;
            }
           
            if (!password) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Password must be filled out.',
                });
                return false;
            }
            return true;
        }