
window.addEventListener('load', () => {
    const songList = document.querySelector('awesomeList')
    const shufflrUrl = 'https://shufflrio.herokuapp.com'

    fetchSongs(shufflrUrl + '/getAllSongs').then(songs => {
        console.log(songs)
        songList.addItems(songs)
    })

    const player = document.querySelector('awesome-audio-player')

    this.addEventListener('song-card-clicked-event', (e) => {
        console.log(`Script: got data for ${e.detail.id} `)
        player.data = {
            title: e.detail.title,
            artist: e.detail.artist,
            source: getAudioSrc(e.detail.id),
        }
    })

    this.addEventListener('search-event', (e) => {
        songList.search(e.detail.searchContent)
    })

    this.addEventListener('upload-event', (e) => {
        console.log("Upload event captured")
    })

    this.addEventListener('logout-event', (e) => {
        console.log("Logout event captured")

        deleteCookie('id')
        window.location.href = shufflrUrl
    })

})

function getAudioSrc(id) {
    if(Number(id) === 0) return "/track1.mp3"
    if(Number(id) === 1) return "/track2.mp3"
    else return "/track2.mp3"
}

async function fetchSongs(url) {
    console.log(`Fetching with cookie: ${getCookie('id')}`)
    console.log(url)
    const customHeaders = new Headers()
    customHeaders.append("Cookie", "id=5")

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