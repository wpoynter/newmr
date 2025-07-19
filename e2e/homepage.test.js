import assert from 'node:assert/strict';
import {test} from 'node:test';

const baseUrl = process.env.BASE_URL || 'http://localhost:8000';

async function fetchText(url) {
  const res = await fetch(url);
  assert.equal(res.status, 200);
  return res.text();
}

test('homepage loads', async () => {
  const text = await fetchText(baseUrl);
  assert.match(text, /wordpress/i);
});

test('navigate to sample page', async () => {
  const text = await fetchText(`${baseUrl}/sample-page/`);
  assert.match(text, /sample page/i);
});
