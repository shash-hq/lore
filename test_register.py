import urllib.request
import urllib.parse
from html.parser import HTMLParser

class CSRFParser(HTMLParser):
    def __init__(self):
        super().__init__()
        self.csrf = None

    def handle_starttag(self, tag, attrs):
        if tag == "input":
            attrs_dict = dict(attrs)
            if attrs_dict.get("name") == "_token":
                self.csrf = attrs_dict.get("value")

url = "http://127.0.0.1:8080/register"
req = urllib.request.Request(url)
with urllib.request.urlopen(req) as response:
    html = response.read().decode('utf-8')
    cookie = response.headers.get('Set-Cookie')

parser = CSRFParser()
parser.feed(html)
csrf = parser.csrf

data = urllib.parse.urlencode({
    '_token': csrf,
    'name': 'Verifier',
    'username': 'verifier',
    'email': 'verify@lore.com',
    'password': 'password123',
    'password_confirmation': 'password123'
}).encode('ascii')

headers = {}
if cookie:
    headers['Cookie'] = cookie

req = urllib.request.Request(url, data=data, headers=headers, method='POST')
try:
    with urllib.request.urlopen(req) as response:
        print("Success:", response.url)
except urllib.error.HTTPError as e:
    if e.code == 302:
        print("Redirected correctly to:", e.headers.get('Location'))
    else:
        print("Error:", e.code, e.read().decode('utf-8'))
