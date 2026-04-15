<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->all();

        $genders = [
            1 => '男性',
            2 => '女性',
            3 => 'その他',
        ];

        $contact['gender_text'] = $genders[$contact['gender']];

        $category = Category::find($contact['category_id']);
        $contact['category_name'] = $category->content;

        return view('confirm', compact('contact'));
    }

    public function store(Request $request)
    {
        if ($request->has('back')) {
            return redirect('/')->withInput();
        }

        Contact::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'tel' => $request->tel1 . $request->tel2 . $request->tel3,
            'address' => $request->address,
            'building' => $request->building,
            'category_id' => $request->category_id,
            'detail' => $request->detail,
        ]);

        return view('thanks');
    }

    public function admin()
    {
        $categories = Category::all();

        $contacts = Contact::with('category')->paginate(7);

        return view('admin', compact('contacts', 'categories'));
    }

    public function search(Request $request)
    {
        $contacts = Contact::with('category')
            ->keywordSearch($request->keyword)
            ->genderSearch($request->gender)
            ->categorySearch($request->category_id)
            ->dateSearch($request->date)
            ->paginate(7);

        $categories = Category::all();

        $contacts->appends($request->all());

        return view('admin', compact('contacts', 'categories'));
    }

    public function export(Request $request)
    {
        $contacts = Contact::with('category')
            ->keywordSearch($request->keyword)
            ->genderSearch($request->gender)
            ->categorySearch($request->category_id)
            ->dateSearch($request->date)
            ->get();

        return new StreamedResponse(function () use ($contacts) {
            $stream = fopen('php://output', 'w');

            stream_filter_append($stream, 'convert.iconv.utf-8/cp932//TRANSLIT');

            fputcsv($stream, [
                'お名前',
                '性別',
                'メールアドレス',
                '電話番号',
                '住所',
                '建物名',
                'お問い合わせの種類',
                'お問い合わせ内容',
            ]);

            foreach ($contacts as $contact) {
                fputcsv($stream, [
                    $contact->last_name . ' ' . $contact->first_name,
                    $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他'),
                    $contact->email,
                    $contact->tel,
                    $contact->address,
                    $contact->building,
                    $contact->category->content,
                    $contact->detail,
                ]);
            }
            fclose($stream);
        }, 200, [
            'content-Type' => 'text/csv',
            'content-Disposition' => 'attachment; filename="contacts_' . date('YmdHis') . '.csv"',
        ]);
    }

    public function destroy(Request $request)
    {
        Contact::find($request->id)->delete();

        return redirect('/admin');
    }
}
