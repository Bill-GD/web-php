<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?= App\Helpers\PageComponent::import_styles() ?>
  <title>Document</title>
</head>

<body>
  <?= App\Helpers\PageComponent::page_header() ?>
  <div class="clearfix container-xl px-3 px-md-4 px-lg-5 mt-4">

    <div class="d-flex flex-justify-between mb-md-3 flex-column-reverse flex-md-row flex-items-end">
      <div class="d-flex flex-justify-start flex-auto my-4 my-md-0 width-full width-md-auto" role="search">
        <button class="btn btn-primary color-border-emphasis Button--secondary">Filter</button>

        </form>
        <form class="subnav-search width-full d-flex " data-pjax="#repo-content-pjax-container"
          data-turbo-frame="repo-content-turbo-frame" role="search" aria-label="Issues" data-turbo="false"
          action="/Bill-GD/web-php/issues" accept-charset="UTF-8" method="get">
          <input type="text" name="q" id="js-issues-search" value="is:issue is:open "
            class="form-control form-control subnav-search-input input-contrast width-full"
            placeholder="Search all issues" aria-label="Search all issues" data-hotkey="Control+/,Meta+/" />
          <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true"
            class="subnav-search-icon">
            <path
              d="M10.68 11.74a6 6 0 0 1-7.922-8.982 6 6 0 0 1 8.982 7.922l3.04 3.04a.749.749 0 0 1-.326 1.275.749.749 0 0 1-.734-.215ZM11.5 7a4.499 4.499 0 1 0-8.997 0A4.499 4.499 0 0 0 11.5 7Z">
            </path>
          </svg>
        </form>
      </div>
      <div class="ml-3 d-flex flex-justify-between width-full width-md-auto">
        <a href="#" data-hotkey="c" data-view-component="true" class="Button--primary Button--medium Button"> <span
            class="Button-content">
            <span class="Button-label">New issue</span>
          </span>
        </a>
      </div>
    </div>

    <div class="mt-3 Box--responsive">
      <div class="Box-header d-flex flex-justify-between">
        <div class="mr-3 d-none d-md-block">
          <input id="myCheckBox" type="checkbox" data-check-all aria-label="Select all issues" autocomplete="off">
        </div>

        <div class="table-list-filters flex-auto d-flex min-width-0">
          <div class="flex-auto d-none d-lg-block no-wrap">

            <div class="table-list-header-toggle states flex-auto pl-0" aria-live="polite">
              <a href="/Bill-GD/web-php/issues?q=is%3Aopen+is%3Aissue" class="btn-link selected"
                data-ga-click="Issues, Table state, Open">
                <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16"
                  data-view-component="true" class="octicon octicon-issue-opened">
                  <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z"></path>
                  <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0ZM1.5 8a6.5 6.5 0 1 0 13 0 6.5 6.5 0 0 0-13 0Z"></path>
                </svg>
                0 Open
              </a>

              <a href="/Bill-GD/web-php/issues?q=is%3Aissue+is%3Aclosed" class="btn-link "
                data-ga-click="Issues, Table state, Closed">
                <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16"
                  data-view-component="true" class="octicon octicon-check">
                  <path
                    d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z">
                  </path>
                </svg>
                1 Closed
              </a>
            </div>

          </div>

          <div class="table-list-header-toggle no-wrap d-flex flex-auto flex-justify-between flex-lg-justify-end">

            <details class="details-reset details-overlay d-inline-block position-relative px-3"
              id="author-select-menu">
              <summary class="btn-link" title="Author" data-hotkey="u" aria-haspopup="true"
                data-ga-click="Issues, Table filter, Author">
                Author
                <span class="dropdown-caret hide-sm"></span>
              </summary>
              <details-menu class="SelectMenu SelectMenu--hasFilter right-lg-0" role="menu"
                src="/Bill-GD/web-php/issues/show_menu_content?partial=issues%2Ffilters%2Fauthors_content&amp;q=is%3Aissue+is%3Aopen"
                preload>
                <div class="SelectMenu-modal">
                  <div class="SelectMenu-list select-menu-list" data-filter="author">
                    <div data-filterable-for="author-filter-field" data-filterable-type="substring">
                      <a class="SelectMenu-item" aria-checked="false" role="menuitemradio"
                        href="/Bill-GD/web-php/issues?q=is%3Aissue+is%3Aopen+author%3Aduongducbinh">
                        <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16"
                          data-view-component="true"
                          class="octicon octicon-check SelectMenu-icon SelectMenu-icon--check">
                          <path
                            d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z">
                          </path>
                        </svg>
                        <img class="avatar flex-shrink-0 mr-2 avatar-user"
                          src="https://avatars.githubusercontent.com/u/96820104?s=40&amp;v=4" width="20" height="20"
                          alt="@duongducbinh" />
                        <strong class="mr-2">duongducbinh</strong>
                        <span class="color-fg-muted css-truncate css-truncate-overflow"></span>
                      </a>

                      <include-fragment class="SelectMenu-loading">
                        <svg style="box-sizing: content-box; color: var(--color-icon-primary);" width="32" height="32"
                          viewBox="0 0 16 16" fill="none" data-view-component="true"
                          class="mx-auto d-block anim-rotate">
                          <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2"
                            vector-effect="non-scaling-stroke" fill="none" />
                          <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" vector-effect="non-scaling-stroke" />
                        </svg>
                      </include-fragment>
                    </div>
                    <!-- '"` --><!-- </textarea></xmp> --></option>
                    </form>
                    <form class="select-menu-new-item-form js-new-item-form" data-turbo="false"
                      action="/Bill-GD/web-php/issues?q=is%3Aopen+is%3Aissue" accept-charset="UTF-8" method="get">
                      <input type="hidden" name="q" value="is:issue is:open">
                      <button class="SelectMenu-item d-block js-new-item-value" type="submit" name="author"
                        role="menuitem">
                        <div class="text-bold f5">author:<span class="js-new-item-name"></span></div>
                        <div class="color-fg-muted">Filter by this user</div>
                      </button>
                    </form>
                  </div>
                </div>
              </details-menu>
            </details>


            <details class="details-reset details-overlay d-inline-block position-relative px-3" id="label-select-menu">
              <summary class="btn-link" title="Label" data-hotkey="l" aria-haspopup="true"
                data-ga-click="Issues, Table filter, Label">
                Label
                <span class="dropdown-caret hide-sm"></span>
              </summary>
              <details-menu class="SelectMenu SelectMenu--hasFilter right-lg-0" role="menu"
                src="/Bill-GD/web-php/issues/show_menu_content?partial=issues%2Ffilters%2Flabels_content&amp;q=is%3Aissue+is%3Aopen"
                preload>
                <div class="SelectMenu-modal">


                  <include-fragment class="SelectMenu-loading">
                    <svg style="box-sizing: content-box; color: var(--color-icon-primary);" width="32" height="32"
                      viewBox="0 0 16 16" fill="none" data-view-component="true" class="mx-auto d-block anim-rotate">
                      <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2"
                        vector-effect="non-scaling-stroke" fill="none" />
                      <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        vector-effect="non-scaling-stroke" />
                    </svg>
                  </include-fragment>
                  <footer class="SelectMenu-footer">
                    <div class="text-left">
                      <span>Use <kbd class="js-modifier-key">alt</kbd> + <kbd>click/return</kbd> to exclude
                        labels</span>
                    </div>
                    <div class="text-left mt-1">
                      <span>or <kbd>⇧</kbd> + <kbd>click/return</kbd> for logical OR</span>
                    </div>
                  </footer>
                </div>
              </details-menu>
            </details>

            <span class="d-none d-md-inline">

              <details class="details-reset details-overlay d-inline-block position-relative px-3"
                id="project-select-menu">
                <summary data-hotkey="p" aria-haspopup="true" data-ga-click="Issues, Table filter, Projects"
                  data-view-component="true" class="btn-link"> Projects
                  <span class="dropdown-caret hide-sm"></span>
                </summary> <details-menu class="SelectMenu SelectMenu--hasFilter right-lg-0" role="menu"
                  src="/Bill-GD/web-php/issues/show_menu_content?partial=issues%2Ffilters%2Fprojects_content&amp;pulls_only=false&amp;q=is%3Aissue+is%3Aopen"
                  preload>
                  <div class="SelectMenu-modal">

                    <include-fragment class="SelectMenu-loading">
                      <svg style="box-sizing: content-box; color: var(--color-icon-primary);" width="32" height="32"
                        viewBox="0 0 16 16" fill="none" data-view-component="true" class="mx-auto d-block anim-rotate">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2"
                          vector-effect="non-scaling-stroke" fill="none" />
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2"
                          stroke-linecap="round" vector-effect="non-scaling-stroke" />
                      </svg>
                    </include-fragment>
                  </div>
                </details-menu>
              </details>


              <details class="details-reset details-overlay d-inline-block position-relative px-3"
                id="milestones-select-menu">
                <summary data-hotkey="m" aria-haspopup="true" data-ga-click="Issues, Table filter, Milestones"
                  data-view-component="true" class="btn-link"> Milestones
                  <span class="dropdown-caret hide-sm"></span>
                </summary> <details-menu class="SelectMenu SelectMenu--hasFilter right-lg-0" role="menu"
                  src="/Bill-GD/web-php/issues/show_menu_content?partial=issues%2Ffilters%2Fmilestones_content&amp;pulls_only=false&amp;q=is%3Aissue+is%3Aopen"
                  preload>
                  <div class="SelectMenu-modal">
                    <include-fragment class="SelectMenu-loading">
                      <svg style="box-sizing: content-box; color: var(--color-icon-primary);" width="32" height="32"
                        viewBox="0 0 16 16" fill="none" data-view-component="true" class="mx-auto d-block anim-rotate">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2"
                          vector-effect="non-scaling-stroke" fill="none" />
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2"
                          stroke-linecap="round" vector-effect="non-scaling-stroke" />
                      </svg>
                    </include-fragment>
                  </div>
                </details-menu>
              </details>

            </span>

            <details class="details-reset details-overlay d-inline-block position-relative px-3"
              id="assignees-select-menu">
              <summary class="btn-link" title="Assignees" data-hotkey="a" aria-haspopup="true"
                data-ga-click="Issues, Table filter, Assignee">
                Assignee
                <span class="dropdown-caret hide-sm"></span>
              </summary>
              <details-menu class="SelectMenu SelectMenu--hasFilter right-md-0" role="menu"
                src="/Bill-GD/web-php/issues/show_menu_content?partial=issues%2Ffilters%2Fassigns_content&amp;q=is%3Aissue+is%3Aopen"
                preload>
                <div class="SelectMenu-modal">
                  <div class="SelectMenu-list select-menu-list" data-filter="assignee">
                    <div data-filterable-for="assigns-filter-field" data-filterable-type="substring">
                      <a class="SelectMenu-item " aria-checked="false"
                        href="/Bill-GD/web-php/issues?q=is%3Aissue+is%3Aopen+no%3Aassignee" role="menuitemradio">
                        <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16"
                          data-view-component="true"
                          class="octicon octicon-check SelectMenu-icon SelectMenu-icon--check">
                          <path
                            d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z">
                          </path>
                        </svg>
                        <strong>Assigned to nobody</strong>
                      </a>
                      <a class="SelectMenu-item" aria-checked="false" role="menuitemradio"
                        href="/Bill-GD/web-php/issues?q=is%3Aissue+is%3Aopen+assignee%3Aduongducbinh">
                        <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16"
                          data-view-component="true"
                          class="octicon octicon-check SelectMenu-icon SelectMenu-icon--check">
                          <path
                            d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z">
                          </path>
                        </svg>
                        <img class="avatar flex-shrink-0 mr-2 avatar-user"
                          src="https://avatars.githubusercontent.com/u/96820104?s=40&amp;v=4" width="20" height="20"
                          alt="@duongducbinh" />
                        <strong class="mr-2">duongducbinh</strong>
                        <span class="color-fg-muted css-truncate css-truncate-overflow"></span>
                      </a>
                      <include-fragment class="SelectMenu-loading">
                        <svg style="box-sizing: content-box; color: var(--color-icon-primary);" width="32" height="32"
                          viewBox="0 0 16 16" fill="none" data-view-component="true"
                          class="mx-auto d-block anim-rotate">
                          <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2"
                            vector-effect="non-scaling-stroke" fill="none" />
                          <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" vector-effect="non-scaling-stroke" />
                        </svg>
                      </include-fragment>
                    </div>
                    <!-- '"` --><!-- </textarea></xmp> --></option>
                    </form>
                    <form class="select-menu-new-item-form js-new-item-form" data-turbo="false"
                      action="/Bill-GD/web-php/issues?q=is%3Aopen+is%3Aissue" accept-charset="UTF-8" method="get">
                      <input type="hidden" name="q" value="is:issue is:open">
                      <button class="SelectMenu-item d-block js-new-item-value" type="submit" name="assignee"
                        role="menuitem">
                        <div class="text-bold f5">assignee:<span class="js-new-item-name"></span></div>
                        <div class="color-fg-muted">Filter by this user</div>
                      </button>
                    </form>
                  </div>
                </div>
              </details-menu>
            </details>


            <details class="details-reset details-overlay d-inline-block position-relative pr-3 pr-sm-0 px-3"
              id="sort-select-menu">
              <summary class="btn-link" aria-haspopup="true" data-ga-click="Issues, Table filter, Sort">
                Sort<span></span>
                <span class="dropdown-caret hide-sm"></span>
              </summary>
              <details-menu class="SelectMenu SelectMenu--hasFilter right-0" role="menu" aria-label="Sort by">
                <div class="SelectMenu-modal">

                  <div class="SelectMenu-list">
                    <a class="SelectMenu-item" aria-checked="true" role="menuitemradio"
                      href="/Bill-GD/web-php/issues?q=is%3Aopen+is%3Aissue">
                      <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16"
                        data-view-component="true" class="octicon octicon-check SelectMenu-icon SelectMenu-icon--check">
                        <path
                          d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z">
                        </path>
                      </svg>
                      <span>Newest</span>
                    </a>
                    <a class="SelectMenu-item" aria-checked="false" role="menuitemradio"
                      href="/Bill-GD/web-php/issues?q=is%3Aissue+is%3Aopen+sort%3Acreated-asc">
                      <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16"
                        data-view-component="true" class="octicon octicon-check SelectMenu-icon SelectMenu-icon--check">
                        <path
                          d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z">
                        </path>
                      </svg>
                      <span>Oldest</span>
                    </a>
                  </div>
                </div>
              </details-menu>
            </details>

          </div>
        </div>

        <div class="table-list-triage flex-auto js-issues-toolbar-triage" style="display: none;">
          <span class="color-fg-muted">
            <span data-check-all-count>0</span> selected
          </span>

          <div class="table-list-header-toggle float-right">
            <span class="js-issue-triage-spinner" hidden>
              <svg aria-label="Saving" style="box-sizing: content-box; color: var(--color-icon-primary);" width="16"
                height="16" viewBox="0 0 16 16" fill="none" data-view-component="true"
                class="v-align-text-bottom anim-rotate">
                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2"
                  vector-effect="non-scaling-stroke" fill="none" />
                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  vector-effect="non-scaling-stroke" />
              </svg>
            </span>
            <span class="color-fg-danger f6 js-issue-triage-error" hidden>Something went wrong.</span>
            <details class="details-reset details-overlay select-menu d-inline-block js-issue-triage-menu"
              data-url="/duongducbinh/first/issues/show_menu_content?partial=issues%2Ftriage%2Factions_content">
              <summary data-view-component="true" class="select-menu-button btn-link"> Mark as
              </summary> <details-menu class="SelectMenu-modal position-absolute right-0" style="z-index: 99;">
                <!-- '"` --><!-- </textarea></xmp> --></option>
                </form>
                <form data-turbo="false" action="/duongducbinh/first/issues/triage" accept-charset="UTF-8"
                  method="post">
                  <input type="hidden" name="_method" value="put" autocomplete="off" /><input type="hidden"
                    name="authenticity_token"
                    value="_LUeutkE1OO5m1pyWYkSMxckI-VQzgkImUr9rBMEGpwyolA-_-xvwI-zBS-_lVpCrBre5bph_Rqw2Ez2VNYY9g" />
                  <div class="SelectMenu-header">
                    <span class="SelectMenu-title">Actions</span>
                  </div>
                  <div class="js-triage-deferred-content"></div>
                </form>
              </details-menu>
            </details>

            <details
              class="details-reset details-overlay select-menu label-select-menu d-inline-block js-issue-triage-menu"
              data-url="/duongducbinh/first/issues/show_menu_content?partial=issues%2Ftriage%2Flabels_content">
              <summary data-view-component="true" class="select-menu-button btn-link"> Label
              </summary> <details-menu class="SelectMenu-modal position-absolute right-0" style="z-index: 99;">
                <!-- '"` --><!-- </textarea></xmp> --></option>
                </form>
                <form data-turbo="false" action="/duongducbinh/first/issues/triage" accept-charset="UTF-8"
                  method="post">
                  <input type="hidden" name="_method" value="put" autocomplete="off" /><input type="hidden"
                    name="authenticity_token"
                    value="Ol-vryOP84V_E3PSZD7a2AknIzBN9yNQk7bm4PwD7uH0SOErBWdIpkk7LI-CIpKpshneMKdY10K6JFe6u9Hsiw" />
                  <div class="SelectMenu-header">
                    <span class="SelectMenu-title">Apply labels</span>
                  </div>

                  <div class="select-menu-filters">
                    <div class="SelectMenu-filter">
                      <input type="text" id="triage-label-filter-field"
                        class="SelectMenu-input form-control js-filterable-field" placeholder="Filter labels"
                        aria-label="Filter labels" autocomplete="off" autofocus>
                    </div>
                  </div>

                  <div class="js-triage-deferred-content"></div>
                </form>
              </details-menu>
            </details>

            <details class="select-menu details-reset details-overlay d-inline-block position-relative px-3"
              id="triage-project-select-menu">
              <summary data-view-component="true" class="btn-link"> <span>Projects</span>
                <span class="dropdown-caret hide-sm"></span>
              </summary> <details-menu class="SelectMenu SelectMenu--hasFilter right-lg-0" role="menu"
                src="/duongducbinh/first/issues/show_menu_content?partial=issues%2Ftriage%2Fprojects_content" preload>
                <!-- '"` --><!-- </textarea></xmp> --></option>
                </form>
                <form class="js-project-picker-form" data-turbo="false" action="/duongducbinh/first/issues/triage"
                  accept-charset="UTF-8" method="post"><input type="hidden" name="_method" value="put"
                    autocomplete="off" /><input type="hidden" name="authenticity_token"
                    value="mwu_ijiwijUJSHeS5lwljl4YjEdy9PnYFibWeVLQkEdVHPEOHlgxFj9gKM8AQG3_5SZxR5hbDco_tGcjFQKSLQ" />
                  <div class="SelectMenu-modal">
                    <header class="SelectMenu-header">
                      <span class="SelectMenu-title">Add to project(s)</span>
                      <button class="SelectMenu-closeButton" type="button" data-toggle-for="project-select-menu">
                        <svg aria-label="Close menu" role="img" height="16" viewBox="0 0 16 16" version="1.1" width="16"
                          data-view-component="true" class="octicon octicon-x">
                          <path
                            d="M3.72 3.72a.75.75 0 0 1 1.06 0L8 6.94l3.22-3.22a.749.749 0 0 1 1.275.326.749.749 0 0 1-.215.734L9.06 8l3.22 3.22a.749.749 0 0 1-.326 1.275.749.749 0 0 1-.734-.215L8 9.06l-3.22 3.22a.751.751 0 0 1-1.042-.018.751.751 0 0 1-.018-1.042L6.94 8 3.72 4.78a.75.75 0 0 1 0-1.06Z">
                          </path>
                        </svg>
                      </button>
                    </header>
                    <include-fragment class="SelectMenu-loading">
                      <svg style="box-sizing: content-box; color: var(--color-icon-primary);" width="32" height="32"
                        viewBox="0 0 16 16" fill="none" data-view-component="true" class="mx-auto d-block anim-rotate">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2"
                          vector-effect="non-scaling-stroke" fill="none" />
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2"
                          stroke-linecap="round" vector-effect="non-scaling-stroke" />
                      </svg>
                    </include-fragment>
                  </div>
                </form>
              </details-menu>
            </details>


            <details class="details-reset details-overlay select-menu d-inline-block js-issue-triage-menu"
              data-url="/duongducbinh/first/issues/show_menu_content?partial=issues%2Ftriage%2Fmilestones_content">
              <summary data-view-component="true" class="select-menu-button btn-link"> Milestone
              </summary> <details-menu class="SelectMenu-modal position-absolute right-0" style="z-index: 99;">
                <!-- '"` --><!-- </textarea></xmp> --></option>
                </form>
                <form data-turbo="false" action="/duongducbinh/first/issues/triage" accept-charset="UTF-8"
                  method="post">
                  <input type="hidden" name="_method" value="put" autocomplete="off" /><input type="hidden"
                    name="authenticity_token"
                    value="eC6fSEKebX0exLgu_1hN3nYkNmC7rY5FG5VQhGcxmye2OdHMZHbWXijs53MZRAWvzRrLYFECelcyB-HeIOOZTQ" />
                  <div class="SelectMenu-header">
                    <span class="SelectMenu-title">Set milestone</span>
                  </div>

                  <div class="select-menu-filters">
                    <div class="SelectMenu-filter">
                      <input type="text" id="triage-milestones-filter-field"
                        class="SelectMenu-input form-control js-filterable-field" placeholder="Filter milestones"
                        aria-label="Filter milestones" autocomplete="off" autofocus>
                    </div>
                  </div>

                  <div class="js-triage-deferred-content"></div>
                </form>
              </details-menu>
            </details>

            <details class="details-reset details-overlay select-menu d-inline-block js-issue-triage-menu"
              data-url="/duongducbinh/first/issues/show_menu_content?partial=issues%2Ftriage%2Fassigns_content">
              <summary data-view-component="true" class="select-menu-button btn-link"> Assign
              </summary> <details-menu class="SelectMenu-modal position-absolute right-0" style="z-index: 99;">
                <!-- '"` --><!-- </textarea></xmp> --></option>
                </form>
                <form data-turbo="false" action="/duongducbinh/first/issues/triage" accept-charset="UTF-8"
                  method="post">
                  <input type="hidden" name="_method" value="put" autocomplete="off" /><input type="hidden"
                    name="authenticity_token"
                    value="xEX3OliIbazGMlFzZpbjEUU1USzzC-DuXYV9kSlQ09YKUrm-fmDWj_AaDi6Aiqtg_gusLBmkFPx0F8zLboLRvA" />
                  <div class="SelectMenu-header">
                    <span class="SelectMenu-title">Assign someone</span>
                  </div>
                  <div class="select-menu-filters">
                    <div class="SelectMenu-filter">
                      <input type="text" id="triage-assigns-filter-field"
                        class="SelectMenu-input form-control js-filterable-field" placeholder="Filter users"
                        aria-label="Filter users" autocomplete="off" autofocus>
                    </div>
                  </div>

                  <div class="js-triage-deferred-content"></div>
                </form>
              </details-menu>
            </details>

            <template class="js-triage-loader-template">
              <include-fragment class="SelectMenu-loading">
                <div data-hide-on-error>
                  <svg style="box-sizing: content-box; color: var(--color-icon-primary);" width="32" height="32"
                    viewBox="0 0 16 16" fill="none" data-view-component="true" class="mx-auto d-block anim-rotate">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2"
                      vector-effect="non-scaling-stroke" fill="none" />
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                      vector-effect="non-scaling-stroke" />
                  </svg>
                </div>
                <div class="text-center p-3" data-show-on-error hidden>
                  <p>Something went wrong.</p>
                  <button data-retry-button="" type="button" data-view-component="true" class="btn-sm btn"> Retry
                  </button>
                </div>
              </include-fragment>
            </template>

            <template id="js-triage-add-issues-to-memex-projects-form-success">

              <div class="flash flash-full flash-success  ">
                <div>
                  <button autofocus class="flash-close js-flash-close" type="button" aria-label="Dismiss this message">
                    <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16"
                      data-view-component="true" class="octicon octicon-x">
                      <path
                        d="M3.72 3.72a.75.75 0 0 1 1.06 0L8 6.94l3.22-3.22a.749.749 0 0 1 1.275.326.749.749 0 0 1-.215.734L9.06 8l3.22 3.22a.749.749 0 0 1-.326 1.275.749.749 0 0 1-.734-.215L8 9.06l-3.22 3.22a.751.751 0 0 1-1.042-.018.751.751 0 0 1-.018-1.042L6.94 8 3.72 4.78a.75.75 0 0 1 0-1.06Z">
                      </path>
                    </svg>
                  </button>
                  <div aria-atomic="true" role="alert" class="js-flash-alert">

                    <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16"
                      data-view-component="true" class="octicon octicon-check">
                      <path
                        d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z">
                      </path>
                    </svg>
                    {{selectedIssueCountLabel}} issue{{selectedIssuesLabel}} successfully been added to
                    {{selectedMemexProjectsLabel}}

                  </div>
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>


      <div class="container-md">
        <div data-hpc="" data-view-component="true" class="blankslate blankslate-large blankslate-spacious">
          <svg aria-hidden="true" height="24" viewBox="0 0 24 24" version="1.1" width="24" data-view-component="true"
            class="octicon octicon-issue-opened blankslate-icon">
            <path
              d="M12 1c6.075 0 11 4.925 11 11s-4.925 11-11 11S1 18.075 1 12 5.925 1 12 1ZM2.5 12a9.5 9.5 0 0 0 9.5 9.5 9.5 9.5 0 0 0 9.5-9.5A9.5 9.5 0 0 0 12 2.5 9.5 9.5 0 0 0 2.5 12Zm9.5 2a2 2 0 1 1-.001-3.999A2 2 0 0 1 12 14Z">
            </path>
          </svg>

          <h3>There aren’t any open issues.</h3>
          <p>You could search <a href="/search">all of GitHub</a> or try an <a href="/search/advanced">advanced
              search</a>.</p>

        </div>
      </div>


    </div>


  </div>

  </div>

  <div class="paginate-container d-none d-sm-flex flex-sm-justify-center">
  </div>

  <div class="paginate-container d-sm-none mb-5">
  </div>

  <div id="issues-index-tip" class="mt-3 text-center color-fg-muted">
    <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true"
      class="octicon octicon-light-bulb color-fg-muted">
      <path
        d="M8 1.5c-2.363 0-4 1.69-4 3.75 0 .984.424 1.625.984 2.304l.214.253c.223.264.47.556.673.848.284.411.537.896.621 1.49a.75.75 0 0 1-1.484.211c-.04-.282-.163-.547-.37-.847a8.456 8.456 0 0 0-.542-.68c-.084-.1-.173-.205-.268-.32C3.201 7.75 2.5 6.766 2.5 5.25 2.5 2.31 4.863 0 8 0s5.5 2.31 5.5 5.25c0 1.516-.701 2.5-1.328 3.259-.095.115-.184.22-.268.319-.207.245-.383.453-.541.681-.208.3-.33.565-.37.847a.751.751 0 0 1-1.485-.212c.084-.593.337-1.078.621-1.489.203-.292.45-.584.673-.848.075-.088.147-.173.213-.253.561-.679.985-1.32.985-2.304 0-2.06-1.637-3.75-4-3.75ZM5.75 12h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1 0-1.5ZM6 15.25a.75.75 0 0 1 .75-.75h2.5a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75Z">
      </path>
    </svg>
    <strong class="color-fg-default">ProTip!</strong>
    Add <a class="Link--inTextBlock" href="/Bill-GD/web-php/issues?q=is%3Aissue+is%3Aopen+no%3Aassignee">no:assignee</a>
    to see everything that’s not
    assigned.
  </div>



  </div>

</body>

<script>
  document.getElementById('myCheckBox').addEventListener('change', function() {
    var boxHeader = document.querySelector('.Box-header');
    var tableListFilters = document.querySelector('.table-list-filters');
    var tableListTriage = document.querySelector('.table-list-triage');

    if (this.checked) {
      boxHeader.classList.add('triage-mode');
      tableListFilters.style.display = 'none';
      tableListTriage.style.display = 'block';
    } else {
      boxHeader.classList.remove('triage-mode');
      tableListFilters.style.display = 'block';
      tableListTriage.style.display = 'none';
    }
  });
</script>

</html>