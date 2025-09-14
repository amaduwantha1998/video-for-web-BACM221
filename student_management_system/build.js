const { exec } = require('child_process');
const path = require('path');

const inputCssPath = path.resolve(__dirname, 'css', 'input.css');
const outputCssPath = path.resolve(__dirname, 'css', 'tailwind.css');

const tailwindcssExecutable = path.resolve(__dirname, 'node_modules', '.bin', 'tailwindcss');
const command = `"${tailwindcssExecutable}" -i "${inputCssPath}" -o "${outputCssPath}"`;

exec(command, (error, stdout, stderr) => {
  if (error) {
    console.error(`Error building Tailwind CSS: ${error.message}`);
    return;
  }
  if (stderr) {
    console.error(`Tailwind CSS stderr: ${stderr}`);
    return;
  }
  console.log(`Tailwind CSS built successfully: ${stdout}`);
});
