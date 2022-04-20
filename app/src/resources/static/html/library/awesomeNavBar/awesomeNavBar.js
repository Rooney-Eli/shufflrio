class AwesomeNavBar extends HTMLElement {

    #searchInputBox
    #uploadBtn
    #logoutBtn

    constructor() {
        super()
        this.attachShadow({ mode: 'open' })
        this.#render()
    }

    connectedCallback() {
        this.#searchInputBox.addEventListener('input', () => {
            this.dispatchEvent(new CustomEvent('search-event', {
                bubbles: true,
                composed: true,
                detail: {
                    searchContent: this.#searchInputBox.value
                }
            }))
        })


        this.#uploadBtn.addEventListener('click', () => {
            this.dispatchEvent(new CustomEvent('upload-event', {
                bubbles: true,
                composed: true,
                detail: {
                    action: 'upload'
                }
            }))
        })

        this.#logoutBtn.addEventListener('click', () => {
            this.dispatchEvent(new CustomEvent('logout-event', {
                bubbles: true,
                composed: true,
                detail: {
                    action: 'logout'
                }
            }))
        })

    }



    #render() {
        this.shadowRoot.innerHTML = `
            <style>
                :host {
                    width: 100%;
                    max-width: 1000px;
                    height: 200px;
                }
                
                :host * {
                    box-sizing: border-box;
                }
                
                .nav-body {
                    margin: 0;
                    display: flex;
                    flex-direction: row;
                    justify-content: space-between;
                    align-content: center;
                    position: relative;
                    overflow: hidden;
                    background: #cccccc;
                    box-shadow:
                        inset 3px 2px 30px 5px rgba(0,0,0,0.2),
                        0 0  0 1px rgb(255,255,255),
                        8px 5px 10px rgba(0,0,0,0.4);
                }
                
                .logo, 
                .upload-btn,
                .logout-btn{
                    margin: 5px;
                    width: 40px;
                    min-width: 40px;
                    height:40px;
                }
                .logo {

                   background: url("/html/library/awesomeNavBar/logo.png");
                   background-size: cover;
                }

                .upload-btn {
                    border-radius: 10px;
                    background: url("/html/library/awesomeNavBar/upload.png");
                    background-size: cover;
                }
                
                .logout-btn {
                    border-radius: 10px;
                    background: url("/html/library/awesomeNavBar/logout.png");
                    background-size: cover;
                }
                
                

                
                .search-bar {              
                    flex-grow: 1;
                    display: flex;
                    margin: 5px;
                    max-width: 400px;
                    background: #dddddd;
                    height: 40px;
                }
                
                .search-input {
                   padding-left: 5px;
                   flex: 1;
                   background: inherit;
                   border: none;
                   height: 100%;
                }
                
                .search-btn{
                    margin: 0;
                    width: 40px;
                    min-width: 40px;
                    height:40px;
                    background: url("/html/library/awesomeNavBar/search.png");
                    background-size: cover;
                    border: none;
                }
                
                .action-buttons {
                    display: flex;
                    flex-direction: row;
                    justify-content: space-between;
                    overflow: hidden;
                }
        </style>
            <div class="nav-body">
                <button class="logo" type="button"></button>
                <div class="search-bar">
                    <button class="search-btn" type="button"></button>
                    <input class="search-input" type="text" spellcheck="false" placeholder="Search...">
                    
                </div>
                <div class="action-buttons"> 
                    <button class="upload-btn" type="button"></button>
                    <button class="logout-btn" type="button"></button>
                </div>
            </div>
        `

        this.#searchInputBox = this.shadowRoot.querySelector('.search-input')
        this.#uploadBtn = this.shadowRoot.querySelector('.upload-btn')
        this.#logoutBtn = this.shadowRoot.querySelector('.logout-btn')

    }

}

export default { AwesomeNavBar }

window.customElements.define('awesome-nav-bar', AwesomeNavBar)