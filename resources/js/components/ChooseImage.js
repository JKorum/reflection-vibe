import React, { useEffect, Fragment } from "react";
import ReactDOM from "react-dom";

const $target = document.getElementById("choose-image");
const $preview = document.getElementById("image-preview");

const ChooseImage = () => {
    const handleChange = e => {
        if ($preview) {
            /* maybe add support for other types later? */
            if (e.target.files[0].type === "image/jpeg") {
                const reader = new FileReader();
                reader.onload = e => {
                    $preview.setAttribute("src", e.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        }
    };

    useEffect(() => {
        const $label = document.getElementById("image-label");
        const $input = document.getElementById("image");
        if ($input && $label) {
            const handler = () => {
                if ($input.value) {
                    $label.innerText = $input.value
                        .toLowerCase()
                        .replace("c:\\fakepath\\", "");
                } else {
                    $label.innerText = "Choose image";
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
                id="image"
                name="image"
                onChange={$preview ? handleChange : null}
            />
            <label
                className="custom-file-label"
                htmlFor="image"
                id="image-label"
            >
                Choose image
            </label>
        </Fragment>
    );
};

export default ChooseImage;

if ($target) {
    ReactDOM.render(<ChooseImage />, $target);
}
