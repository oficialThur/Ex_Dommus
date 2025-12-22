const call = new BroadcastChannel('sw_channel');

call.onmessage = (event) => {
    const responseData = event.data

    console.log("Dados recebidos da Aba A:")

    console.log(JSON.stringify(responseData, null, 2))
}