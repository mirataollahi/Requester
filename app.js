async function addRequest(id , url)
{
    let newRow = $('#sample_response_item').clone();
    newRow.find('.req-id').html(id);
    newRow.find('.req-host').html(url);
    newRow.find('.req-status-code').html('connecting...');
    newRow.find('.req-status-code').first().addClass('req-status-code-' + id);
    newRow.find('.req-time').html('connecting...');
    newRow.find('.req-time').addClass('req-time-' + id);
    newRow.show();

    $('#response-body').append(newRow);
    let time = 0;

    await axios.get(apiServer + '?url=' + encodeURIComponent(url))
        .then(function (response) {
            newRow.find('.req-status-code-' + id).html(response.data.data.code);
            newRow.find('.req-time-' + id).html(response.data.data.time);
            if (response.data.data.time)
            time =  response.data.data.time;
        })
        .catch(function (error) {
            newRow.find('.req-stats-code' + id).html('500');
            newRow.find('.req-time' + id).html('0');
        });

    return time;
}





const firstSite = $('.first-site').html();
const secondSite = $('.first-site').html();
const apiServer = 'http://localhost:8000/Request.php';
let requestCounter = 1 ;

for (let i = 0; i < 10; i++) {
    if (firstSite) {
        addRequest(requestCounter, firstSite).then(result => {
            let time = $('.first-site-responses-time').html() + parseInt(result) ;
            $('.first-site-responses-time').html(time)
        });
        requestCounter++;
    }
    if (firstSite) {
        addRequest(requestCounter, firstSite).then(result => {
            let time = $('.second-site-responses-time').html() + parseInt(result) ;
            $('.second-site-responses-time').html(time)
        });
        requestCounter++;
    }

}


