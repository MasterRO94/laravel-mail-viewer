@extends('mail-viewer::layouts.app')

@section('content')
	<div class="flex mb-4">
		@include('mail-viewer::mails._sidebar')

		<main class="w-3/4 px-2">
			<div v-if="currentMail" v-cloak>
				<header class="text-base px-2 py-2">
					<h3 class="mb-2 text-grey-darkest" v-text="currentMail.subject"></h3>
					<p class="text-sm">
						<strong>From:</strong>
						<span class="text-grey-darkest" v-html="currentMail.formattedFrom"></span>
					</p>
					<p class="text-sm mt-1">
						<strong>To:</strong>
						<span class="text-grey-darkest" v-html="currentMail.formattedTo"></span>
					</p>
					<p class="text-sm mt-1" v-show="currentMail.formattedCc">
						<strong>Cc:</strong>
						<span class="text-grey-darkest" v-html="currentMail.formattedCc"></span>
					</p>
					<p class="text-sm mt-1" v-show="currentMail.formattedBcc">
						<strong>Bcc:</strong>
						<span class="text-grey-darkest" v-html="currentMail.formattedBcc"></span>
					</p>
				</header>
				<tabs>
					<tab name="Preview">
						<iframe :srcdoc="currentMail.body"
						        frameborder="0"
						        width="100%"
						        height="600px"
						></iframe>
					</tab>
					<tab name="HTML">
						<div class="overflow-x-scroll">
							<pre class="text-xs"><code v-text="currentMail.body"></code></pre>
						</div>
					</tab>
				</tabs>
			</div>
		</main>
	</div>
@endsection