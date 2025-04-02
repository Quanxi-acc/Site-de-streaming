const canvas = document.createElement("canvas");
document.body.appendChild(canvas);
const ctx = canvas.getContext("2d");
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

const clouds = [];
const numClouds = 10;

for (let i = 0; i < numClouds; i++) {
    clouds.push({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height / 2,
        speed: 0.5 + Math.random() * 1.5,
        size: 50 + Math.random() * 100
    });
}

function drawSky() {
    const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
    gradient.addColorStop(0, "#87CEEB"); // Bleu ciel
    gradient.addColorStop(1, "#f0f8ff"); // Bleu très clair
    ctx.fillStyle = gradient;
    ctx.fillRect(0, 0, canvas.width, canvas.height);
}

function drawClouds() {
    ctx.fillStyle = "rgba(255, 255, 255, 0.8)";
    clouds.forEach(cloud => {
        ctx.beginPath();
        ctx.arc(cloud.x, cloud.y, cloud.size, 0, Math.PI * 2);
        ctx.fill();
        cloud.x += cloud.speed;
        if (cloud.x - cloud.size > canvas.width) {
            cloud.x = -cloud.size;
            cloud.y = Math.random() * canvas.height / 2;
        }
    });
}

function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawSky();
    drawClouds();
    requestAnimationFrame(animate);
}

window.addEventListener("resize", () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});

animate();
