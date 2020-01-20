import React, { useEffect, Fragment } from "react";
import ReactDOM from "react-dom";

const $target = document.getElementById("choose-avatar");

const ChooseAvatar = () => {
    useEffect(() => {
        const $input = document.getElementById("avatar");
        const $label = document.getElementById("avatar-label");
        if ($input && $label) {
            const handler = () => {
                if ($input.value) {
                    $label.innerText = $input.value
                        .toLowerCase()
                        .replace("c:\\fakepath\\", "");
                } else {
                    $label.innerText = "Choose avatar";
                }
            };
            $input.addEventListener("input", handler);
            return () => {
                $input.removeEventListener("input", handler);
            };
        }
    }, []);

    return (
        <Fragment>
            <input
                type="file"
                className="custom-file-input"
                id="avatar"
                name="avatar"
            />
            <label
                className="custom-file-label"
                htmlFor="avatar"
                id="avatar-label"
            >
                Choose avatar
            </label>
        </Fragment>
    );
};

export default ChooseAvatar;

if ($target) {
    ReactDOM.render(<ChooseAvatar />, $target);
}
