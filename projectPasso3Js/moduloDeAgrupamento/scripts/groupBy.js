export const groupBy = (array, key) => {
    return array.reduce((hash, obj) => {
        if (obj[key] === undefined || obj[key] === null) {
            return hash
        }
        const valueKey = obj[key];
        if (!hash[valueKey]) {
            hash[valueKey] = [];
        }
        hash[valueKey].push(obj);
        return hash

    }, {})
}