export class LCG {
    constructor(seed) {
        if (typeof seed === 'string') {
            this.seed = this.stringToHash(seed);
        } else {
            this.seed = seed;
        }
        this.modulus = 2 ** 31 - 1;
        this.multiplier = 1664525;
        this.increment = 1013904223;
    }

    stringToHash(str) {
        // Simple hash function to convert a string to an integer
        let hash = 0;
        for (let i = 0; i < str.length; i++) {
            hash = (hash << 5) - hash + str.charCodeAt(i);
            hash = hash & hash; // Convert to 32bit integer
        }
        return Math.abs(hash); // Ensure positive integer
    }

    next() {
        this.seed = (this.multiplier * this.seed + this.increment) % this.modulus;
        return this.seed / this.modulus;
    }
}
