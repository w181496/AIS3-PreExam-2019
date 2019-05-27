from flask import Flask, Response
from flask import render_template
from flask import request

app = Flask(__name__)

@app.route("/")
def hello():
    return render_template("index.html")

@app.route("/flag")
def flag():
    user_agent = request.headers.get('User-Agent')
    black_list = ["curl", "Curl", "Python", "CURL", "PHP", "python", "Ruby", "iPhone"]
    for i in black_list:
        if i in user_agent:
            return "Request Error~"
    return render_template("flag.html")

@app.route("/manifest.json")
def manifest():
    s = '''
{
    "name": "Kaibro",
    "short_name": "Kaibro",
    "icons": [{
        "src": "/favicon.ico",
        "sizes": "192x192",
        "type": "image/png"
    }],
    "start_url": "/",
    "display": "standalone",
    "orientation": "portrait",
    "background_color": "#FAFAFA",
    "theme_color": "#6387F5"
}
'''
    return s

@app.route("/sw.js")
def sw():
    s = '''
this.addEventListener('install', function(event) {
  console.log('Perform install steps');
  event.waitUntil(
    caches.open('v1').then(function(cache) {
      console.log('Opened cache');
      return cache.addAll([
        '/flag',
      ]);
    })
  );
});

this.addEventListener('activate', function(event){
  console.log('activated!')
});

this.addEventListener('fetch', function(event) {
  console.log('Handling fetch event for', event.request.url);

  event.respondWith(
    caches.match(event.request).then(function(response) {
      if (response) {
        return new Response('<h2>Flag is here! But I catch it!</h2><img src="https://kaibro.tw/kana.gif">', {
                   headers: { 'Content-Type': 'text/html' }
                            });
        console.log('Found response in cache:', response);
        return response;
      } else {
        console.log('No response found in cache. About to fetch from network...');
      }

      return fetch(event.request).then(function(response) {
        console.log('Response from network is:', response);
        // return caches.open('v1').then(function(cache) {
        //   cache.put(event.request, response.clone());
        //   return response;
        // });
        return response;
      }).catch(function(error) {
        console.error('Fetching failed:', error);
        throw error;
      });
    })
  );
});
''' 
    return Response(s, mimetype='text/javascript')

if __name__ == "__main__":
    app.run(host='0.0.0.0', port='35000', ssl_context=('cert.pem', 'key.pem'))

