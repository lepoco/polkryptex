export default function () {
    arguments[0] = { raw: arguments[0] };
    return String.raw(...arguments);
}