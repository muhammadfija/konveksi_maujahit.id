const https = require('https');

https.get('https://www.google.com/maps/search/Mau+jait+id+erustan+clothing+Katapang', (res) => {
  let data = '';
  res.on('data', chunk => data += chunk);
  res.on('end', () => {
    const match = data.match(/"(https:\/\/www\.google\.com\/maps\/embed\?pb=[^"]+)"/);
    if (match) {
      console.log(match[1]);
    } else {
      console.log('Not found');
    }
  });
}).on('error', err => console.log(err));
