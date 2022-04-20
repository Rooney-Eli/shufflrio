
window.addEventListener('load', () => {
    const listOfSongs = []
    const songList = document.querySelector('awesome-list')
    const shufflrUrl = 'https://shufflrio.herokuapp.com'

    fetchSongs(shufflrUrl + '/getAllSongs').then(songs => {
        console.log(songs)
        if(songs.length !== 0) {
            console.log(`adding ${songs}`)
            listOfSongs.push(songs)
            listOfSongs.forEach((it) => {
                console.log(`song: ${it}`)})
            songList.addItems(songs)
        }
    })

    const player = document.querySelector('awesome-audio-player')

    this.addEventListener('song-card-clicked-event', (e) => {
        console.log(`Script: got data for ${e.detail.songId} `)
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
        console.log("Upload event captured")
    })

    this.addEventListener('logout-event', (e) => {
        console.log("Logout event captured")

        deleteCookie('id')
        window.location.href = shufflrUrl
    })

    function getAudioSource(songId) {
        console.log("Getting src")
        console.log(songId)
        const result = listOfSongs.find((song) => {
            return songId === song.songId
        })

        console.log(result)
        return result.filepath
    }

})


async function fetchSongs(url) {
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