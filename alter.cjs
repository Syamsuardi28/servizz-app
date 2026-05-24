require('dotenv').config({ path: '../servizz-api/.env' });
const { query } = require('../servizz-api/src/config/db');

(async () => {
  try {
    console.log('Altering users table to add is_active column...');
    await query(`ALTER TABLE users ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1`);
    console.log('Success!');
  } catch(err) {
    if(err.code === 'ER_DUP_FIELDNAME') {
      console.log('Column is_active already exists. Skipping.');
    } else {
      console.error('Error:', err);
    }
  }
  process.exit(0);
})();
