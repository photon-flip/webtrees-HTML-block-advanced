function convertCrossReferenceLinks() {
    let rectype = {
        'i': 'individual',
        'f': 'family',
        's': 'source',
        'r': 'repository',
        'n': 'note',
        'l': 'sharedPlace'
    };
    let separator = {
        'default': {
            'path': '%2F',
            'option': '&'
        },
        'pretty': {
            'path': '/',
            'option': '?'
        }
    };
    let baseurl = document.location.href.match(/^.+?\/index\.php\?route=(?:%2F.+?)*%2Ftree%2F([^%\/#?]+)/i) || document.location.href.match(/^.+?\/tree\/([^\/#?]+)/i);
    if (!baseurl) {
        return
    }
    let tree = baseurl[1];
    baseurl = baseurl[0];
    let urlmode = (baseurl.indexOf('index.php') > -1 ? 'default' : 'pretty');
    let diatitle = $("a.dropdown-item.menu-chart-tree[role=menuitem]").text().trim() || 'Interaktives Sanduhrdiagramm';

    $('a[href^="#@"]').each(function (index, element) {
        let link = $(this).attr('href');
        let m = link.match(/^#@([ifsrnl])=@([^@]+)@(.*)/i);
        if (m) {
            let type = m[1].toLowerCase();
            let xref = m[2];
            let param = m[3];
            let dia = false;
            if (param.match(/\+dia/i)) {
                dia = true;
                param = param.replace(/\+dia/i, '')
            }
            let newtree = param;
            let url = (newtree ? baseurl.replace(`/tree/${tree}`.replaceAll('/', separator[urlmode].path), `/tree/${newtree}`.replaceAll('/', separator[urlmode].path)) : baseurl);
            $(this).attr('href', url + separator[urlmode].path + rectype[type] + separator[urlmode].path + xref).attr('target', '_blank');
            if (type == 'i' && dia) {
                let diaurl = url.replace("/tree/".replaceAll('/', separator[urlmode].path), "/module/tree/Chart/".replaceAll('/', separator[urlmode].path)) + separator[urlmode].option + "xref=" + xref;
                $(this).after($(' <a/>', {
                    href: diaurl,
                    class: 'menu-chart-tree',
                    target: '_blank',
                    title: `${diatitle} - ${xref}` + ($(this).text() ? ' / ' + $(this).text() : ''),
                    html: '&nbsp;'
                }));
            }
        }
    });
}

$(document).ready(function () {
    convertCrossReferenceLinks();
});
