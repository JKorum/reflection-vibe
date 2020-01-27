import React, { Fragment, useEffect, useState } from "react";
import ReactDOM from "react-dom";
import Moment from "react-moment";

const $target = document.getElementById("comments-section");
const owner = $target && +$target.dataset.postOwner;

const Comments = () => {
    const [comments, setComments] = useState([]);
    const [disable, setDisable] = useState(true);

    useEffect(() => {
        const getPostComments = async postId => {
            const res = await axios.get(`/posts/${postId}/comments`);
            if (res.status === 200 && res.data.length > 0) {
                setComments(res.data);
            }
        };

        try {
            const path = window.location.pathname;
            const postId = path.match(/\d+/)[0];
            getPostComments(postId);

            const timer = setInterval(() => {
                getPostComments(postId);
            }, 20000);

            return () => {
                clearInterval(timer);
            };
        } catch (err) {
            console.log(err);
        }
    }, []);

    const handlePostComment = async e => {
        e.preventDefault();
        postComment();
    };

    const postComment = async () => {
        const $comment = document.getElementById("comment-input");
        if ($comment.value !== "") {
            const path = window.location.pathname;
            const postId = path.match(/\d+/)[0];
            const res = await axios.post(`/posts/${postId}/comments`, {
                comment: $comment.value.trim()
            });
            if (res.status === 200) {
                setComments(res.data);
                $comment.value = "";
                setDisable(true);
            }
        }
    };

    const handleEnter = e => {
        if (e.key === "Enter") {
            e.preventDefault();
            if (!disable) {
                postComment();
            }
        }
    };

    const handleChange = e => {
        if (e.target.value !== "") {
            setDisable(false);
        } else {
            setDisable(true);
        }
    };

    const handleDeleteComment = async comment => {
        try {
            if (owner) {
                /* user is post owner */
                const path = window.location.pathname;
                const postId = path.match(/\d+/)[0];
                const res = await axios.delete(
                    `/posts/${postId}/comments/${comment}`
                );
                if (res.status === 200 && res.data) {
                    setComments(res.data);
                }
            }
        } catch (err) {
            console.log(err);
        }
    };

    return (
        <Fragment>
            <form id="form" onSubmit={handlePostComment}>
                <div className="input-group">
                    <textarea
                        id="comment-input"
                        className="form-control border-0 pl-0 pr-0"
                        placeholder="Post a comment"
                        rows="1"
                        style={{
                            resize: "none",
                            boxShadow: "none",
                            background: "inherit"
                        }}
                        onKeyDown={handleEnter}
                        onChange={handleChange}
                    ></textarea>
                    <div className="input-group-append">
                        <button
                            className="btn btn-link text-decoration-none"
                            type="submit"
                            disabled={disable}
                        >
                            Post
                        </button>
                    </div>
                </div>
            </form>
            <hr className="mt-2 mb-2" />
            <div>
                {comments.length > 0
                    ? comments.map(comment => (
                          <div key={comment.id} className="d-flex mb-3">
                              <div
                                  className="pr-2 flex-shrink-0"
                                  style={{ width: "50px" }}
                              >
                                  <img
                                      src={comment.avatar}
                                      className="rounded-circle w-100"
                                  />
                              </div>
                              <div className="pr-2 flex-grow-1">
                                  <p className="mb-0">
                                      <span className="font-weight-bold">
                                          {comment.username}{" "}
                                      </span>
                                      {comment.comment}
                                  </p>

                                  <small className="text-muted">
                                      Posted{" "}
                                      <Moment
                                          date={comment.created_at}
                                          format="DD/MM/YYYY"
                                      />
                                  </small>
                              </div>
                              {owner ? (
                                  <div className="pr-2">
                                      <button
                                          type="button"
                                          className="btn btn-sm btn-link text-decoration-none"
                                          onClick={() =>
                                              handleDeleteComment(comment.id)
                                          }
                                      >
                                          &times;
                                      </button>
                                  </div>
                              ) : null}
                          </div>
                      ))
                    : null}
            </div>
        </Fragment>
    );
};

if ($target) {
    ReactDOM.render(<Comments />, $target);
}
