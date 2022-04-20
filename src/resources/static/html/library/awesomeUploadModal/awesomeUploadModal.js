class AwesomeUploadModal extends HTMLElement {

    constructor() {
        super()
        this.attachShadow({ mode: 'open' })
        this.#render()
    }

    #render() {
        this.shadowRoot.innerHTML = `
            <style>
                :host {
                    width: 100vw;
                    height: 100vh;
                }
                
                :host * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                .modal-body {
                    margin: 0;
                    display: flex;
                    flex-direction: row;
                    justify-content: space-between;
                    align-content: center;
                    position: relative;
                }
                
                .modal-content {
                    background: red;
                }
                
            </style>
            <div class="modal-body">
                <div class="modal-content">
                   <h1>Content!</h1>
                </div>
            </div>

        `

        // this.#searchInputBox = this.shadowRoot.querySelector('.search-input')
        // this.#uploadBtn = this.shadowRoot.querySelector('.upload-btn')
        // this.#logoutBtn = this.shadowRoot.querySelector('.logout-btn')

    }

}


export default { AwesomeUploadModal }

window.customElements.define('awesome-upload-modal', AwesomeUploadModal)