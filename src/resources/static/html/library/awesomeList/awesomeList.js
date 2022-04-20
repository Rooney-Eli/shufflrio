class AwesomeList extends HTMLElement {

    #songs = []
    #activeSongId = -1
    #activeElement
    #songList
    #searchTerm = ''

    constructor() {
        super();
        this.attachShadow({ mode: 'open' })
        this.#render()
        this.#attachEvents()
    }

    #attachEvents() {
        this.addEventListener('song-card-clicked-event', (e) => {
            if(this.#activeSongId !== -1) {
                this.#setInactive(this.#activeSongId)
            }
            this.#activeSongId = e.detail.songId
            this.#setActive(e.detail.songId)
        })
    }

    #setActive(id) {
        this.#activeElement = this.#songList.querySelector('[id="'+ CSS.escape(id) +'"]')

        this.#activeElement.setAttribute('playing', 'true')
    }

    #setInactive(id) {
        this.#songList.querySelector('[id="'+ CSS.escape(id) +'"]')
            .setAttribute('playing', 'false')
    }


    addItems(items) {
        this.#songs.push(...items)
        this.#render()
    }

    removeItems() {
        this.#songs = []
    }

    search(term) {
        this.#searchTerm = term
        this.#render()
    }

    getSongs() {
        return this.#songs
    }


    static #style() {
        return `
           <style>
                :host {
                    width: 100%;
                    max-width: 1000px;
                    height: 200px;
                }
                
                :host * {
                    box-sizing: border-box;
                }
                
                .song-list {
                    width: 100%;
                    max-width: 1000px;
                }
            
            </style>
        `
    }


    #GenerateCards() {
        return this.#songs.map((song) => {
            if(this.#searchTerm === ''){
                return `<song-card id="${song.songId}" title="${song.name}" artist="${song.artist}" album="${song.album}"></song-card>`
            } else {
                if(
                    song.name.toLowerCase().includes(this.#searchTerm.toLowerCase()) ||
                    song.album.toLowerCase().includes(this.#searchTerm.toLowerCase()) ||
                    song.artist.toLowerCase().includes(this.#searchTerm.toLowerCase())) {
                    return `<song-card id="${song.songId}" title="${song.name}" artist="${song.artist}" album="${song.album}"></song-card>`
                }
            }


        }).join('')
    }

    #render() {
        this.shadowRoot.innerHTML = `            
        ${AwesomeList.#style()}
        <div class="song-list">
            ${this.#GenerateCards()}
        </div>
        `
        this.#songList = this.shadowRoot.querySelector('.song-list')
    }
}

export default { AwesomeList }

window.customElements.define('awesome-list', AwesomeList)