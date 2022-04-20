class AwesomeUploadModal extends HTMLElement {
    #titleBox;
    #artistBox;
    #albumBox;
    #uploadBtn;
    #cancelBtn;
    #filepathBox;

    constructor() {
        super()
        this.attachShadow({ mode: 'open' })
        this.#render()
        this.#attachEvents()
    }

    #attachEvents() {
        this.#cancelBtn.addEventListener('click', () => {
            this.dispatchEvent(new CustomEvent('close-modal-event', {
                    bubbles: true,
                    composed: true
                }
            ))
        })

        this.#uploadBtn.addEventListener('click', () => {
            this.dispatchEvent(new CustomEvent('upload-file-event', {
                bubbles: true,
                composed: true,
                detail: {
                    title: this.#titleBox.value,
                    artist: this.#artistBox.value,
                    album: this.#albumBox.value,
                    filepath: this.#filepathBox.value
                }
            }))

        })
    }


    #render() {
        this.shadowRoot.innerHTML = `
            <style>
                :host {
                    width: 100vw;
                    height: 100vh;
                    position: fixed;
                    z-index: 9999999;
                }
                
                :host * {
                    box-sizing: border-box;
                }
                
                .modal-body {
                    height: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: #00000066;
                }
                
                .modal-content {
                    height: 300px;
                    width: 200px;
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
                
                .input-group {
                    margin-top: 15px;
                    width: 150px;
                    max-width: 200px;
                    overflow: hidden;
                }
                
                .username-input,
                .password-input {
                    height: 1.5em;
                    text-align: center;
                }
                
                .button-group {
                    margin-top: 30px;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                }
                
                .login-btn,
                .create-btn {
                    padding: 5px;
                    border-radius: 5px;
                    margin: 10px 10px 10px 10px;
                    height: 2em;
                    width: 200px;
                }
                
            </style>
            <div class="modal-body">
                <div class="modal-content">
                    <div class="input-group">
                        <label>Title</label>
                        <input class="title-input" type="text" spellcheck="false">
                    </div>
                    <div class="input-group">
                        <label>Artist</label>
                        <input class="artist-input" type="text" spellcheck="false">
                    </div>
                    <div class="input-group">
                        <label>Album</label>
                        <input class="album-input" type="text" spellcheck="false">
                    </div>
                    
                    <div class="input-group">
                        <label>Filepath</label>
                        <input class="album-input" type="text" spellcheck="false">
                    </div>
                    
                    <div class="button-group">
                        <button class="upload-btn" type="button">Upload</button>
                        <button class="cancel-btn" type="button">Cancel</button>
                    </div>
                    
                </div>
            </div>

        `

        this.#titleBox = this.shadowRoot.querySelector('.title-input')
        this.#artistBox = this.shadowRoot.querySelector('.artist-input')
        this.#albumBox = this.shadowRoot.querySelector('.album-input')
        this.#filepathBox = this.shadowRoot.querySelector('.filepath-input')

        this.#uploadBtn = this.shadowRoot.querySelector('.upload-btn')
        this.#cancelBtn = this.shadowRoot.querySelector('.cancel-btn')

    }

}


export default { AwesomeUploadModal }

window.customElements.define('awesome-upload-modal', AwesomeUploadModal)