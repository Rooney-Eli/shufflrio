class AwesomeAudioPlayer extends HTMLElement {

    #playing = false
    #currentTime = 0
    #duration = 0
    #volume = 1
    #initialized = false
    #looping = false

    #source = ""
    #artist = ""
    #title = ""
    #audioTag
    #playPauseBtn
    #repeatBtn
    #infoElement
    #songTitleElement
    #songArtistElement
    #volumeBar
    #progressIndicator
    #currentTimeElement
    #progressBar
    #durationElement


    constructor() {
        super();
        this.attachShadow({ mode: 'open' })
        this.#render()
    }
    
    set data(value) {
        this.#title = value.title
        this.#songTitleElement.textContent = this.#title

        this.#artist = value.artist
        this.#songArtistElement.textContent = this.#artist

        this.#source = value.source

        console.log(`AwesomeAudioPlayer: Title set to ${value.title}`)
        console.log(`AwesomeAudioPlayer: Artist set to ${value.artist}`)
        console.log(`AwesomeAudioPlayer: Source set to ${value.source}`)

        this.#initialized = false
        this.#render()
        this.#initializeAudio()
    }
    
    #initializeAudio() {
        if(this.#initialized) return
        this.#initialized = true
        this.#volume = 1

        this.audioCtx = new AudioContext()

        this.track = this.audioCtx.createMediaElementSource(this.#audioTag)

        this.gainNode = this.audioCtx.createGain()

        this.track
            .connect(this.gainNode)
            .connect(this.audioCtx.destination)

        this.#changeVolume()
    }


    #attachEvents() {
        this.#playPauseBtn.addEventListener('click', this.#togglePlay.bind(this))
        
        this.#repeatBtn.addEventListener('click', this.#toggleRepeat.bind(this))

        this.#volumeBar.addEventListener('input', this.#changeVolume.bind(this))

        this.#progressBar.addEventListener('input', () => {
            this.#seekTo(this.#progressBar.value)
        })

        this.#audioTag.addEventListener('loadedmetadata', () => {
            this.#duration = this.#audioTag.duration
            this.#progressBar.max = this.#duration

            const seconds = `${parseInt(`${this.#duration % 60}`, 10)}`.padStart(2, '0')
            const minutes = parseInt(`${(this.#duration / 60) % 60}`, 10)

            this.#durationElement.textContent = `${minutes}:${seconds}`
        })

        this.#audioTag.addEventListener('timeupdate', () => {
            this.#updateAudioTime(this.#audioTag.currentTime)
        })

        this.#audioTag.addEventListener('ended', () => {
            this.#playing = false
            this.#playPauseBtn.textContent = 'play'
            this.#playPauseBtn.classList.remove('playing')
        })

        this.#audioTag.addEventListener('pause', () => {
            this.#playing = false
            this.#playPauseBtn.textContent = 'play'
            this.#playPauseBtn.classList.remove('playing')
        })

        this.#audioTag.addEventListener('play', () => {
            this.#playing = true
            this.#playPauseBtn.textContent = 'pause'
            this.#playPauseBtn.classList.add('playing')
        })

    }

    #toggleRepeat() {
        if(this.#looping) {
            this.#audioTag.loop = false
            this.#repeatBtn.classList.remove('repeating')
        } else {
            this.#audioTag.loop = true
            this.#repeatBtn.classList.add('repeating')
        }
        this.#looping = !this.#looping
    }


    async #togglePlay() {
        if(this.audioCtx == null) return

        if(this.audioCtx.state === 'suspended') {
            await this.audioCtx.resume()
        }

        if(this.#playing) {
            return this.#audioTag.pause()
        }

        return this.#audioTag.play()
    }

    #seekTo(value) {
        this.#audioTag.currentTime = value
    }

    #updateAudioTime(time) {
        this.#currentTime = time
        this.#progressBar.value = this.#currentTime

        const seconds = `${parseInt(`${time % 60}`, 10)}`.padStart(2, '0')
        const minutes = parseInt(`${(time / 60) % 60}`, 10)

        this.#currentTimeElement.textContent = `${minutes}:${seconds}`
    }

    #changeVolume() {
        if(this.audioCtx == null) return
        this.#volume = Number(this.#volumeBar.value)

        if(Number(this.#volume) > 0) {
            this.#volumeBar.parentNode.className = 'volume-bar'
        } else {
            this.#volumeBar.parentNode.className = 'volume-bar muted'
        }

        this.gainNode.gain.value = this.#volume
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
                
                .audio-player {
                    height: 100%;
                    width: 100%;
                    background: #cccccc;
                    border-radius: 5px;
                    color:#ffffff;
                    display:grid;
                    grid-template-rows: auto 50px;
                    position: relative;
                    padding: 25px;
                    overflow: hidden;
                    box-shadow:
                        inset 3px 2px 30px 5px rgba(0,0,0,0.2),
                        0 0  0 1px rgb(255,255,255),
                        8px 5px 10px rgba(0,0,0,0.4);
                }
                
                .controls {
                    margin: 0;
                    grid-column: 1/2;
                    display: flex;
                    flex-direction: row;
                    justify-content: space-around;
                }
                

                
                .play-btn,
                .previous-btn,
                .next-btn,
                .repeat-btn,
                .shuffle-btn,
                .volume-bar {
                    margin: 5px;
                    width: 40px;
                    min-width: 40px;
                    height:40px;
                }
                
                .play-btn:hover,
                .previous-btn:hover,
                .next-btn:hover,
                .repeat-btn:hover,
                .shuffle-btn:hover {
                    filter: invert(50%);
                }
                
                
                
                .play-btn {
                    background: url("/src/resources/static/html/library/awesomeAudioPlayer/white-sprite-stripe.png") calc((100%/9)*2) center/1000%  100% no-repeat;
                    background-size: cover;
                    appearance: none;      
                    border: none;   
                    text-indent: -9999999px;
                    overflow: hidden;  
                }           
                .play-btn.playing {
                    background: url("/src/resources/static/html/library/awesomeAudioPlayer/white-sprite-stripe.png") calc((100%/9)*3) center/1000%  100% no-repeat;
                }
    
               .previous-btn {
                    background: url("/src/resources/static/html/library/awesomeAudioPlayer/white-sprite-stripe.png") calc((100%/9)*7) center/1000%  100% no-repeat;
                    background-size: cover;
                    appearance: none;      
                    border: none;   
                    text-indent: -9999999px;
                    overflow: hidden;  
                }           
                
                .next-btn {
                    background: url("/src/resources/static/html/library/awesomeAudioPlayer/white-sprite-stripe.png") calc((100%/9)*6) center/1000%  100% no-repeat;
                    background-size: cover;
                    appearance: none;      
                    border: none;   
                    text-indent: -9999999px;
                    overflow: hidden;  
                }
                .repeat-btn {
                    background: url("/src/resources/static/html/library/awesomeAudioPlayer/white-sprite-stripe.png") calc((100%/9)*1) center/1000%  100% no-repeat;
                    background-size: cover;
                    appearance: none;      
                    border: none;   
                    text-indent: -9999999px;
                    overflow: hidden;  
                }
                .repeat-btn.repeating {
                    filter: invert(100%)
                }
                .shuffle-btn {
                    background: url("/src/resources/static/html/library/awesomeAudioPlayer/white-sprite-stripe.png") 0 center/1000%  100% no-repeat;
                    background-size: cover;
                    appearance: none;      
                    border: none;   
                    text-indent: -9999999px;
                    overflow: hidden;  
                }
                
                .volume-bar {
                    background: url("/src/resources/static/html/library/awesomeAudioPlayer/white-sprite-stripe.png") calc((100%/9)*9) center/1000%  100% no-repeat;
                    background-size: cover;
                    position: relative;
                }
                
                .volume-bar.muted {
                    background: url("/src/resources/static/html/library/awesomeAudioPlayer/white-sprite-stripe.png") calc((100%/9)*8) center/1000%  100% no-repeat;
                }
    
                
                .volume-field {
                    display: none;
                    position: absolute;
                    appearance: none;
                    height: 35px;
                    right: 100%;
                    top: 50%;
                    transform: translateY(-50%);
                    margin: 0;
                    border-radius: 2px;
                    background: #ffffff;
                }
                
                .volume-field::-webkit-slider-thumb {
                    appearance: none;
                    height: 35px;
                    width: 10px;
                    background: #999999;
                }
            
                .volume-field::-moz-range-thumb {
                    appearance: none;
                    height: 35px;
                    width: 10px;
                    background: #999999
                }
            
                .volume-field::-ms-thumb  {
                    appearance: none;
                    height: 35px;
                    width: 10px;
                    background: #999999;
                }
                
                .volume-bar:hover .volume-field {
                    display: block;
                }
                
                .song-info {
                    grid-row: 1/2;
                }
                .song-info > p {
                    margin: 0;
                    padding: 0;
                }
                
                .song-info > .song-title {
                    font-size: 1.3em;
                }
                
                .progress-indicator {
                    grid-row: 2/3;
                    display: flex;
                    justify-content: flex-end;
                    align-items: center;
                    margin-top: 15px;
                    height: 17px;
                    overflow: hidden;
                }
                
                .duration {
                    margin-left: 2px;
                    margin-right: 5px;
                }
                
                .progress-bar {
                    border-radius: 20px;
                    flex-grow: 1;
                    height: 100%;
                    background: #EEEEEE;
                    overflow: hidden;
                    appearance: none;
                } 
                
                .progress-bar::-webkit-slider-thumb{
                    appearance: none;
                    height: 20px;
                    width: 0;
                    box-shadow: -100vw  0 0 100vw #999999
                }            
                
                .progress-bar::-moz-range-thumb{
                    appearance: none;
                    height: 20px;
                    width: 0;
                    box-shadow: -100vw  0 0 100vw #999999
                }            
                .progress-bar::-ms-thumb{
                    appearance: none;
                    height: 20px;
                    width: 0;
                    box-shadow: -100vw  0 0 100vw #999999
                }
                
            </style>
        `
    }

    #render() {
        console.log("AwesomeAudioPlayer: rendering")
        this.shadowRoot.innerHTML = `
            ${AwesomeAudioPlayer.#style()}
            <div class="audio-player">
                <audio src="${this.#source}" style="display: none" autoplay></audio>
                <div class="song-info">
                    <p class="song-title">${this.#title}</p>
                    <p class="song-artist">${this.#artist}</p>
                </div>
                <div class="progress-indicator">
                    <span class="current-time">0:00</span>
                    <input type="range" max="100" value="0" class="progress-bar">
                    <span class="duration">0:00</span>
                </div>
                <div class="controls">
                    <button class="previous-btn" type="button">previous</button>
                    <button class="play-btn" type="button">play</button>
                    <button class="next-btn" type="button">next</button>
                    <button class="repeat-btn" type="button">repeat</button>
                    <button class="shuffle-btn" type="button">shuffle</button>
                    <div class="volume-bar">
                        <input type="range" min="0" max="2" step="0.01" value="${this.#volume}" class="volume-field">
                    </div>
                </div>
            </div>
        `

        this.#audioTag = this.shadowRoot.querySelector('audio')
        this.#playPauseBtn = this.shadowRoot.querySelector('.play-btn')
        this.#repeatBtn = this.shadowRoot.querySelector('.repeat-btn')

        this.#infoElement = this.shadowRoot.querySelector('.song-info')
        this.#songTitleElement = this.#infoElement.children[0]
        this.#songArtistElement = this.#infoElement.children[1]

        this.#volumeBar = this.shadowRoot.querySelector('.volume-field')
        this.#progressIndicator = this.shadowRoot.querySelector('.progress-indicator')
        this.#currentTimeElement = this.#progressIndicator.children[0]
        this.#progressBar = this.#progressIndicator.children[1]
        this.#durationElement = this.#progressIndicator.children[2]

        this.#attachEvents()
    }

}

export default { AwesomeAudioPlayer }

window.customElements.define('awesome-audio-player', AwesomeAudioPlayer)