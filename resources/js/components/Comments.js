import React, { Fragment } from "react";
import ReactDOM from "react-dom";

const $target = document.getElementById("comments-section");

const Comments = () => {
    return (
        <Fragment>
            <form>
                <div className="input-group">
                    <textarea
                        name="comment"
                        className="form-control border-0 pl-0 pr-0"
                        placeholder="Post a comment"
                        rows="1"
                        style={{
                            resize: "none",
                            boxShadow: "none",
                            background: "inherit"
                        }}
                    ></textarea>
                    <div className="input-group-append">
                        <button
                            className="btn btn-link text-decoration-none"
                            type="submit"
                        >
                            Post
                        </button>
                    </div>
                </div>
            </form>
            <hr className="mt-2 mb-2" />
            <div>
                <div className="d-flex mb-3">
                    <div className="pr-2">
                        <img
                            src="https://source.unsplash.com/random/30x30"
                            className="rounded-circle"
                        />
                    </div>
                    <div className="pr-2">
                        <p className="mb-0">
                            <span className="font-weight-bold">Lori </span>Lorem
                            ipsum dolor sit amet consectetur adipisicing elit.
                            Numquam, quod.
                        </p>

                        <small className="text-muted">Posted 12/05/2019</small>
                    </div>
                    <div className="pr-2">&times;</div>
                </div>
                <div className="d-flex mb-3">
                    <div className="pr-2">
                        <img
                            src="https://source.unsplash.com/random/30x30"
                            className="rounded-circle"
                        />
                    </div>
                    <div className="pr-2">
                        <p className="mb-0">
                            <span className="font-weight-bold">Lori </span>Lorem
                            ipsum dolor sit amet consectetur adipisicing elit.
                            Numquam, quod.
                        </p>

                        <small className="text-muted">Posted 12/05/2019</small>
                    </div>
                    <div className="pr-2">&times;</div>
                </div>
                <div className="d-flex mb-3">
                    <div className="pr-2">
                        <img
                            src="https://source.unsplash.com/random/30x30"
                            className="rounded-circle"
                        />
                    </div>
                    <div className="pr-2">
                        <p className="mb-0">
                            <span className="font-weight-bold">Lori </span>Lorem
                            ipsum dolor sit amet consectetur adipisicing elit.
                            Numquam, quod.
                        </p>

                        <small className="text-muted">Posted 12/05/2019</small>
                    </div>
                    <div className="pr-2">&times;</div>
                </div>
            </div>
        </Fragment>
    );
};

if ($target) {
    ReactDOM.render(<Comments />, $target);
}
