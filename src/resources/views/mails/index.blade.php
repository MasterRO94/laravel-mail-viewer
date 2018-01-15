@extends('mail-viewer::layouts.app')

@section('content')
	<div class="flex mb-4">
		<aside class="w-1/4 flex flex-col">
			<section
					v-for="mail in mails.data"
					class="flex mail-item bg-grey-lightest hover:bg-blue-light text-grey-darker hover:text-white border-b border-blue-light hover:border-transparent py-2 px-3 cursor-pointer"
					v-cloak
			>
				<div class="w-3/4 text-sm">
						<span>
							@{{ mail.subject }}
						</span>
					<br>
					<span class="text-xs"><strong>To:</strong><span v-html="mail.formattedTo"></span></span>
				</div>
				<div class="w-1/4 text-sm text-right">
					@{{ mail.formattedDate }}
				</div>
			</section>
			<div class="text-4xl text-blue-dark text-center py-2">
				<i class="fas fa-spinner fa-spin" v-show="loading"></i>
			</div>
		</aside>

		<main class="w-3/4">

		</main>
	</div>
@endsection