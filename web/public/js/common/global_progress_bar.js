var intObj = {
    template: 3,
    parent: '#bug_zilla_progress_div' // this option will insert bar HTML into this parent Element
};
var indeterminateProgress = new Mprogress(intObj);

function globalProgressBarStart() {
    indeterminateProgress.start();
}


function globalProgressBarEnd() {
    indeterminateProgress.end();
}

