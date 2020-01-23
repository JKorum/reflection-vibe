import React, { Fragment, useState } from "react";
import ReactDOM from "react-dom";
import axios from "axios";

const $target = document.getElementById("img-action-bar");
const $liked = $target && +$target.dataset.liked;
const $likers = $target && $target.dataset.likers;
const $others = $target && +$target.dataset.others;

const ImgActionBar = () => {
    const [likers, setLikers] = useState($likers);
    const [others, setOthers] = useState($others);

    const updateLikersLine = async () => {
        const $likersInfo = document.getElementById("likers-info");
        if ($likersInfo) {
            try {
                const path = window.location.pathname;
                const postId = path.match(/\d+/)[0];
                const res = await axios.get(`/posts/${postId}/likers`);
                if (res.status === 200) {
                    const [likers, others] = res.data;
                    setLikers(likers);
                    setOthers(others);
                }
            } catch (err) {
                console.log(err);
            }
        }
    };

    const handleLikeDislike = async () => {
        const postId = $target.dataset.postId;
        const heart = document.getElementById("heart");
        if (postId && heart) {
            try {
                const res = await axios.post(`/posts/${postId}/like`);
                if (res.status === 200) {
                    /* add heart background */
                    if (heart.classList.contains("far")) {
                        heart.classList.remove("far");
                        heart.classList.add("fas");
                    } else {
                        heart.classList.remove("fas");
                        heart.classList.add("far");
                    }
                    updateLikersLine();
                }
            } catch (err) {
                console.log(err);
            }
        }
    };

    return (
        <Fragment>
            <div className="d-flex justify-content-between pt-1">
                <div>
                    <button
                        type="button"
                        className="btn btn-link p-0 text-reset"
                        onClick={handleLikeDislike}
                    >
                        <i
                            id="heart"
                            className={`${
                                $liked ? "fas" : "far"
                            } fa-heart fa-lg mr-1`}
                        ></i>
                    </button>

                    <i className="far fa-comment fa-lg"></i>
                </div>
                <div>
                    <i className="far fa-bookmark fa-lg"></i>
                </div>
            </div>
            <div id="likers-info">
                {likers && (
                    <small>
                        Liked by{" "}
                        <span>
                            {likers.split(",").map((name, i, array) => {
                                return i + 1 === array.length ? (
                                    <Fragment key={name}>
                                        <span className="font-weight-bold">
                                            {name}
                                        </span>
                                        {others ? <span>,</span> : null}
                                    </Fragment>
                                ) : (
                                    <Fragment key={name}>
                                        <span className="font-weight-bold">
                                            {name}
                                        </span>
                                        <span>,</span>
                                    </Fragment>
                                );
                            })}
                        </span>
                        {others ? (
                            <span className="text-muted">
                                {" "}
                                and {others} others
                            </span>
                        ) : null}
                    </small>
                )}
            </div>
        </Fragment>
    );
};

if ($target) {
    ReactDOM.render(<ImgActionBar />, $target);
}
