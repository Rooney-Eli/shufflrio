window.addEventListener('load', () => {
    console.log("Hello world!")
    const shufflrUrl = 'https://shufflrio.herokuapp.com/'

    const awesomeLogin = document.querySelector('awesome-login')

    this.addEventListener('login-event', (e) => {
        authenticateUser(shufflrUrl + '/authenticateUser', e.detail.username, e.detail.password).then(result => {
            const {error} = result
            const {id} = result
            if(error !== undefined) {
                if(error === 'username'){
                    awesomeLogin.data = {
                        username: 'error'
                    }
                } else {
                    awesomeLogin.data = {
                        password: 'error'
                    }
                }
            }
            if(id !== undefined) {
                window.location.reload()
            }
        })
    })

    this.addEventListener('create-event', (e) => {
        createUser(shufflrUrl + '/createUser', e.detail.username, e.detail.password).then(result => {
            const {error} = result
            const {id} = result
            if(error !== undefined) {
                if(error === 'username'){
                    awesomeLogin.data = {
                        username: 'error'
                    }

                } else {
                    awesomeLogin.data = {
                        password: 'error'
                    }
                }
            }
            if(id !== undefined) {
                window.location.reload()
            }
        })
    })


    this.addEventListener('enable-create-event', () => {
        console.log("captured enable create event")
        awesomeLogin.data = {
            createEnable: 'engage'
        }
    })

    this.addEventListener('cancel-create-event', () => {
        console.log("captured disable create event")
        awesomeLogin.data = {
            createEnable: 'disengage'
        }
    })

    this.addEventListener('create-event', () => {
        console.log("captured disable create event")
        awesomeLogin.data = {
            createEnable: 'disengage'
        }
    })



})


async function authenticateUser(url, username, password) {
    const customHeaders = new Headers()
    customHeaders.append("Content-Type", "application/json")

    const body = JSON.stringify( {
        username:username,
        password:password
    })

    const response = await fetch(url, {
        method: 'POST',
        headers: customHeaders,
        body: body,
        redirect:'follow'
    })
    return await response.json()

}

async function createUser(url, username, password) {
    const customHeaders = new Headers()
    customHeaders.append("Content-Type", "application/json")

    const body = JSON.stringify( {
        username:username,
        password:password
    })

    const response = await fetch(url, {
        method: 'POST',
        headers: customHeaders,
        body: body,
        redirect:'follow'
    })
    return await response.json()

}