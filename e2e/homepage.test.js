import assert from 'node:assert/strict';
import {test, before} from 'node:test';
import {execSync} from 'node:child_process';
import path from 'node:path';

const baseUrl = process.env.BASE_URL || 'http://localhost:8000';

async function waitForWordPress(url, timeout = 60000) {
  const start = Date.now();
  while (Date.now() - start < timeout) {
    try {
      const res = await fetch(url);
      if (res.ok) return;
    } catch {
      // ignore errors until timeout
    }
    await new Promise((r) => setTimeout(r, 2000));
  }
  throw new Error('WordPress not responding');
}

before(async () => {
  await waitForWordPress(baseUrl);
  try {
    execSync(
      'docker compose run --rm wpcli wp plugin activate newmr-plugin',
      {
        cwd: path.join(__dirname, '..'),
        stdio: 'inherit',
      },
    );
  } catch {
    // Plugin may already be active or docker unavailable
  }
});

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

test('booth archive loads', async () => {
  const text = await fetchText(`${baseUrl}/exhibition/`);
  assert.ok(text.length > 0);
});
