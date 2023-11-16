export function makeRequest(method, url, data, header) {
    return new Promise(function (resolve, reject) {
        const request = new XMLHttpRequest();
        request.open(method, url);

        if( header ) {
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        }

        request.onload = function () {
            if (this.status >= 200 && this.status < 300) {
                resolve(request.response);
            } else {
                reject({
                    status: this.status,
                    statusText: request.statusText
                });
            }
        };

        request.onerror = function () {
            reject({
                status: this.status,
                statusText: request.statusText
            });
        };

        request.send(data);
    });
}

export function serializeObject(object) {
    let s = "";
   for (let key in object) {
       if (s != "") s += "&";

       s += (key + "=" + encodeURIComponent(object[key]));
   }
   return s;
}

export const requestsArticle = async (data, type=null, wrap=null) => {
    const response = await makeRequest('POST', window.ajaxUrl, data, true);
	if(response) {
        if(type === 'scroll') {
            if (!response.includes('div')) {
                stopFlag = true;
            } else {
                if(wrap) {
                    wrap.insertAdjacentHTML('beforeend', response);
                }
                document.querySelector('body').classList.remove('loading');
            }
        } else {
            wrap.innerHTML = '';
            wrap.innerHTML = response;
            document.querySelector('body').classList.remove('loading');
        }

        let buttonLoadVisible = document.querySelector('.btn-true');
        let buttonLoadShow = document.querySelector('.blog-btn-load');

        if(buttonLoadVisible) {
            buttonLoadVisible.remove();
            buttonLoadShow.classList.remove('load');
        }
	}
};