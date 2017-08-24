

export default Array.prototype.remove = function () {
    const index = this.indexOf(arguments[0]);
    this.splice(index, 1);
};
