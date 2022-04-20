window.addEventListener('load', () => {
    const songList = document.querySelector('awesome-list')
    const shufflrUrl = 'https://shufflrio.herokuapp.com'

    const modal = document.createElement('awesome-upload-modal')
    fetchSongs(shufflrUrl + '/getAllSongs').then(songs => {
        if(songs.length !== 0) {
            songList.addItems(songs)
        }
    })

    const player = document.querySelector('awesome-audio-player')

    this.addEventListener('song-card-clicked-event', (e) => {
        player.data = {
            title: e.detail.title,
            artist: e.detail.artist,
            source: getAudioSource(e.detail.songId),
        }
    })

    this.addEventListener('search-event', (e) => {
        songList.search(e.detail.searchContent)
    })

    this.addEventListener('upload-event', (e) => {
        document.body.appendChild(modal)
    })

    this.addEventListener('close-modal-event', (e) => {
        document.body.removeChild(modal)
    })
    this.addEventListener('upload-file-event', (e) => {
        console.log(`File upload captured for ${e}`)
        sendSong(e)
    })


    this.addEventListener('logout-event', (e) => {
        console.log("Logout event captured")

        deleteCookie('id')
        window.location.href = shufflrUrl
    })

    function getAudioSource(id) {
        const songs = songList.getSongs()

        const {filepath} = songs.find( ({songId, filepath}) => {
            return Number(id) === Number(songId)
        })
        return filepath
    }

    function sendSong(song) {
        uploadSong(shufflrUrl + '/uploadSong', song).then(() => {
            console.log("Song Upload completed.")
            document.body.removeChild(modal)
        })
    }
})

async function uploadSong(url, song) {
    const cookie = getCookie("id")
    const customHeaders = new Headers()
    customHeaders.append("Content-Type", "application/json")
    customHeaders.append("Cookie", `id=${cookie}`)

    const body = JSON.stringify( {
        title: song.title,
        artist: song.artist,
        album: song.album,
        filepath: song.filepath
    })

    const response = await fetch(url, {
        method: 'POST',
        headers: customHeaders,
        body: body,
        redirect:'follow'
    })
    return await response.json()

}

async function fetchSongs(url) {
    const cookie = getCookie("id")
    const customHeaders = new Headers()
    customHeaders.append("Cookie", `id=${cookie}`)

    const response = await fetch(url, {
        method: 'GET',
        headers: customHeaders,
        redirect: 'follow'
    })
    return await response.json()
}

function getCookie(cookieName) {
    let name = cookieName + "=";
    let ca = document.cookie.split(';')
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i]
        while (c.charAt(0) === ' ') {
            c = c.substring(1)
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length)
        }
    }
    return ""
}

function deleteCookie(cookieName) {
    document.cookie = cookieName + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;'
}