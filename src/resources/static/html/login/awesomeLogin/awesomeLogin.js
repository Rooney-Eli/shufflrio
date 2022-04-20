class AwesomeLogin extends HTMLElement {

    #loginBtn
    #createBtn
    #loginBtnText = 'Login'
    #createBtnText = 'Create Account'

    #usernameBox;
    #passwordBox;
    #usernameAttempt = ''
    #passwordAttempt = ''
    #usernameLabelText = 'Username';
    #passwordLabelText = 'Password';

    #isCreateMode = false

    constructor() {
        super()
        this.attachShadow({ mode: 'open' })
        this.#render()
    }

    #attachEvents() {
        this.#loginBtn.addEventListener('click', () => {
            this.#usernameAttempt = this.#usernameBox.value
            this.#passwordAttempt = this.#passwordBox.value
            if(this.#usernameBox.value !== '' && this.#passwordBox.value !== '') {
                if(this.#isCreateMode) {
                    this.dispatchEvent(new CustomEvent('create-event', {
                        bubbles: true,
                        composed: true,
                        detail: {
                            username: this.#usernameBox.value,
                            password: this.#passwordBox.value
                        }
                    }))
                } else {
                    this.dispatchEvent(new CustomEvent('login-event', {
                        bubbles: true,
                        composed: true,
                        detail: {
                            username: this.#usernameBox.value,
                            password: this.#passwordBox.value
                        }
                    }))
                }

                if(this.#usernameBox.value === '') {
                    this.#usernameBox.classList.add('error')
                } else {
                    this.#usernameBox.classList.remove('error')
                }
                if(this.#passwordBox.value === '') {
                    this.#passwordBox.classList.add('error')
                } else {
                    this.#passwordBox.classList.remove('error')
                }

            }
        })

        this.#createBtn.addEventListener('click', () => {
            if(this.#isCreateMode) {
                this.dispatchEvent(new CustomEvent('cancel-create-event', {
                    bubbles: true,
                    composed: true
                }))
            } else {
                this.dispatchEvent(new CustomEvent('enable-create-event', {
                    bubbles: true,
                    composed: true
                }))
            }
        })
    }

    set data(value) {
        if(value.username !== undefined) {
            this.#usernameBox.classList.add('error')
        } else {
            this.#usernameBox.classList.remove('error')
        }
        if(value.password !== undefined) {
            this.#passwordBox.classList.add('error')
        } else {
            this.#passwordBox.classList.remove('error')
        }

        if(value.createEnable !== undefined) {
            if(value.createEnable === 'engage') {
                this.#isCreateMode = true
                this.#usernameLabelText = "Choose a username"
                this.#passwordLabelText = "Choose a password"
                this.#loginBtnText = "Submit"
                this.#createBtnText = "Cancel"
            }
            if(value.createEnable === 'disengage') {
                this.#isCreateMode = false
                this.#usernameLabelText = "Username"
                this.#passwordLabelText = "Password"
                this.#loginBtnText = "Login"
                this.#createBtnText = "Create Account"
            }
            this.#render()
        }
    }

    #render() {
        this.shadowRoot.innerHTML = `
            <style>
                :host {
                    width: 100vw;
                    max-width: 300px;
                    height: 400px;
                }
                
                :host * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                .site-stuff {
                    font-family: 'Exo 2', sans-serif;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: space-around;
                    margin-bottom: 30px;
                }
                
                .input-group {
                    margin-top: 20px;
                    width: 150px;
                    max-width: 200px;
                    overflow: hidden;
                }
                
                .username-input,
                .password-input {
                    height: 1.5em;
                    text-align: center;
                }
                
                .username-input.error,
                .password-input.error {
                    border:1px solid red;
                    box-shadow: 0 0 10px #719ECE;
                }
                
                .username-input:focus,
                .password-input:focus {
                    
                }
                
                .username-input.error:focus,
                .password-input.error:focus {
                      outline: none;
                }
                 
                .login-prompt {
                    height: 100%;
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    overflow: hidden;
                    background: #cccccc;
                    border-radius: 10px;
                    box-shadow:
                        inset 3px 2px 30px 5px rgba(0,0,0,0.2),
                        0 0  0 1px rgb(255,255,255),
                        8px 5px 10px rgba(0,0,0,0.4);
                }         
                
                .button-group {
                    margin-top: 30px;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                }
                
                .login-btn,
                .create-btn {
                    border-radius: 5px;
                    margin: 10px 10px 10px 10px;
                    height: 2em;
                    width: 150px;
                }
                
                     
                
                
            </style>

            <div class="login-prompt">
                <div class="site-stuff">
                    <h1>Shufflr</h1>
                    <h3>Mix it up.</h3>
                </div>
                <div class="input-group">
                    <label>${this.#usernameLabelText}</label>
                    <input class="username-input" type="text" spellcheck="false" placeholder="..." value='${this.#usernameAttempt}'>
                </div>
                <div class="input-group">
                    <label>${this.#passwordLabelText}</label>
                    <input class="password-input" type="password" spellcheck="false" placeholder="..." value='${this.#passwordAttempt}'>
                </div>
                <div class="button-group">
                    <button class="login-btn" type="button">${this.#loginBtnText}</button>
                    <button class="create-btn" type="button">${this.#createBtnText}</button>
                </div>
            </div>
        `

        this.#usernameBox = this.shadowRoot.querySelector('.username-input')
        this.#passwordBox = this.shadowRoot.querySelector('.password-input')

        this.#loginBtn = this.shadowRoot.querySelector('.login-btn')
        this.#createBtn = this.shadowRoot.querySelector('.create-btn')

        this.#attachEvents()

    }
}

export default { AwesomeLogin }

window.customElements.define('awesome-login', AwesomeLogin)