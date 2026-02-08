import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { fileURLToPath } from 'url';
import { dirname, resolve } from 'path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

export default defineConfig({
    build: {
        outDir: resolve(__dirname, '../../public/build-relatorios'),
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            input: {
                app: resolve(__dirname, 'resources/assets/js/app.js'),
                charts: resolve(__dirname, 'resources/assets/js/charts.js'),
                filters: resolve(__dirname, 'resources/assets/js/filters.js'),
                styles: resolve(__dirname, 'resources/assets/sass/app.scss'),
            },
        },
    },
    plugins: [
        laravel({
            publicDirectory: resolve(__dirname, '../../public'),
            buildDirectory: 'build-relatorios',
            input: [
                resolve(__dirname, 'resources/assets/sass/app.scss'),
                resolve(__dirname, 'resources/assets/js/app.js'),
                resolve(__dirname, 'resources/assets/js/charts.js'),
                resolve(__dirname, 'resources/assets/js/filters.js')
            ],
            refresh: true,
        }),
    ],
});
// Scen all resources for assets file. Return array
//function getFilePaths(dir) {
//    const filePaths = [];
//
//    function walkDirectory(currentPath) {
//        const files = readdirSync(currentPath);
//        for (const file of files) {
//            const filePath = join(currentPath, file);
//            const stats = statSync(filePath);
//            if (stats.isFile() && !file.startsWith('.')) {
//                const relativePath = 'Modules/Relatorios/'+relative(__dirname, filePath);
//                filePaths.push(relativePath);
//            } else if (stats.isDirectory()) {
//                walkDirectory(filePath);
//            }
//        }
//    }
//
//    walkDirectory(dir);
//    return filePaths;
//}

//const __filename = fileURLToPath(import.meta.url);
//const __dirname = dirname(__filename);

//const assetsDir = join(__dirname, 'resources/assets');
//export const paths = getFilePaths(assetsDir);


//export const paths = [
//    'Modules/Relatorios/resources/assets/sass/app.scss',
//    'Modules/Relatorios/resources/assets/js/app.js',
//];
