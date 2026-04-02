// js/contact.js

const emptyForm = () => ({
    firstName: '',
    lastName: '',
    email: '',
    message: '',
    honeypot: '',
    testAnswer: ''
});

const ContactApp = {
    data() {
        return {
            formData: emptyForm(),
            responseMessage: '',
            errors: {},
            buttonText: "Submit Message",
            submitted: false
        }
    },
    methods: {
        async submitForm() {
            // Clear old states
            this.errors = {};
            this.responseMessage = '';

            try {
                const response = await fetch('contact.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json' // Matches our new PHP logic
                    },
                    body: JSON.stringify(this.formData)
                });

                const data = await response.json();

                if (data.errors) {
                    this.errors = data.errors;
                    return;
                }

                // Success State
                this.errors = {};
                this.responseMessage = data.message;
                this.formData = emptyForm();
                this.submitted = true;
                this.buttonText = ""; // Makes room for the SVG tick

            } catch (error) {
                console.error("Submission Error:", error);
                this.errors = {
                    general: "Connection lost. Please check your internet and try again."
                };
            }
        }
    }
};

// Initialize and mount
const { createApp } = Vue;
createApp(ContactApp).mount("#app");