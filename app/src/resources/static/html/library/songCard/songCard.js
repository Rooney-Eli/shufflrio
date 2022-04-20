class SongCard extends HTMLElement {

    #songId = -1
    #title = "unknown title"
    #artist = "unknown artist"
    #album = "unknown album"
    #playing = ''
    #cardContainer

    constructor() {
        super()
        this.attachShadow({ mode: 'open' })
    }

    connectedCallback() {
        this.shadowRoot.addEventListener('click', () => {
            this.dispatchEvent(new CustomEvent('song-card-clicked-event', {
                bubbles: true,
                composed: true,
                detail: {
                    songId: this.#songId,
                    title: this.#title,
                    artist: this.#artist,
                    album: this.#album,
                }
            }))
        })
    }


    attributeChangedCallback(attribute, oldValue, newValue) {
        switch (attribute) {
            case 'id':
                this.#songId = newValue
                break;
            case 'title':
                this.#title = newValue
                break
            case 'artist':
                this.#artist = newValue
                break
            case 'album':
                this.#album = newValue
                break
            case 'playing':
                console.log(`Playing toggled for ${this.#songId} : ${newValue}`)
                newValue === 'true' ? this.#playing = 'active' : this.#playing = ''
                break
        }
        this.render()
    }

    static get observedAttributes() {
        return ['id', 'title', 'artist', 'album', 'playing']
    }


    render() {
        this.shadowRoot.innerHTML = `
            <style>
                .card-container {
                    display: flex;
                    flex-direction: column;
                    justify-content: space-evenly;
                    height: 150px;
                    width: 90%;
                    padding: 10px 20px 10px 20px;
                    margin: 0 5% 0 5%;
                    border: black;
                    border-radius: 10px;
                    background: #ccccff;
                    overflow: hidden;
                    box-shadow:
                            inset 3px 2px 30px 5px rgba(0,0,0,0.2),
                            0 0  0 1px rgb(255,255,255),
                            8px 5px 10px rgba(0,0,0,0.4);
                }
                .card-container.active {
                    box-shadow:
                            inset 3px 2px 30px 5px rgba(255,255,0,0.5),
                            0 0  0 1px rgb(255,255,0),
                            8px 5px 10px rgba(0,0,0,0.4);
                }
                
                :host * {
                   box-sizing: border-box;
                }
                
                h1 {
                    flex-grow: 2;
                    margin: 0;
                    padding: 5px 10px 0 10px;
                    justify-content: center;
                }
            
                h2 {
                    flex-grow: 1;
                    margin: 0;
                    padding: 5px;
                }
            
            </style>
            <div class="card-container ${this.#playing}">
                <h2>${this.#artist}</h2>
                <h1>${this.#title}</h1>
                <h1>${this.#album}</h1>
            </div>
        `

        this.#cardContainer = this.shadowRoot.querySelector('.card-container')

    }
}

export default { SongCard }

window.customElements.define('song-card', SongCard)