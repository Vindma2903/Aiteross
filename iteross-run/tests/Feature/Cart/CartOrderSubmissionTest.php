<?php

namespace Tests\Feature\Cart;

use App\Modules\Cart\Infrastructure\Mail\CartOrderSubmittedMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CartOrderSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_cart_order_request(): void
    {
        Mail::fake();

        $response = $this->post(route('cart-order-requests.store'), [
            'name' => 'Иван Иванов, ООО «Компания»',
            'phone' => '+7 (999) 123-45-67',
            'email' => 'sales@example.com',
            'comment' => 'Нужна отгрузка на следующей неделе.',
            'items' => [
                ['product_id' => 1, 'sku' => 'CNMG120408-GM', 'name' => 'Пластина CNMG120408-GM', 'material' => 'Сталь', 'price' => 1190, 'qty' => 20, 'url' => '/products/cnmg120408-gm'],
                ['product_id' => null, 'sku' => 'MGMN300-M-GM', 'name' => 'Пластина MGMN300-M-GM', 'material' => 'Жаропрочные сплавы', 'price' => null, 'qty' => 10, 'url' => '/products/mgmn300-m-gm'],
            ],
        ]);

        $response
            ->assertRedirect(route('cart.index'))
            ->assertSessionHas('status', 'Заявка отправлена. Менеджер свяжется с вами для подтверждения и счёта.')
            ->assertSessionHas('cart_submitted', true);

        $this->assertDatabaseHas('cart_order_requests', [
            'name' => 'Иван Иванов, ООО «Компания»',
            'phone' => '+7 (999) 123-45-67',
            'email' => 'sales@example.com',
            'total_quantity' => 30,
            'total_price' => 23800,
            'has_unknown_price' => true,
            'status' => 'new',
        ]);

        Mail::assertSent(
            CartOrderSubmittedMail::class,
            function ($mail): bool {
                return $mail->hasTo((string) config('services.lead_requests.recipient'))
                    && $mail->data->name === 'Иван Иванов, ООО «Компания»'
                    && count($mail->data->items) === 2
                    && $mail->data->totalQuantity() === 30;
            }
        );
    }

    public function test_guest_can_submit_cart_order_request_with_items_as_json_string(): void
    {
        // The cart page posts "items" as a single JSON-encoded hidden field
        // (built client-side from localStorage), not as bracket-notation
        // array fields. This mirrors that real request shape.
        Mail::fake();

        $items = json_encode([
            ['product_id' => 6, 'sku' => 'MGMN-300-M', 'name' => 'Пластина MGMN-300-M', 'material' => '', 'price' => null, 'qty' => 10, 'url' => '/products/mgmn-300'],
        ]);

        $response = $this->post(route('cart-order-requests.store'), [
            'name' => 'Иван Иванов',
            'phone' => '+7 (999) 123-45-67',
            'items' => $items,
        ]);

        $response
            ->assertRedirect(route('cart.index'))
            ->assertSessionHas('status')
            ->assertSessionDoesntHaveErrors();

        Mail::assertSent(
            CartOrderSubmittedMail::class,
            fn ($mail) => $mail->data->items[0]['sku'] === 'MGMN-300-M'
                && $mail->data->items[0]['price'] === null,
        );
    }

    public function test_cart_order_request_requires_contact_and_items(): void
    {
        Mail::fake();

        $response = $this->from(route('cart.index'))->post(route('cart-order-requests.store'), [
            'name' => '',
            'phone' => '',
            'items' => [],
        ]);

        $response
            ->assertRedirect(route('cart.index'))
            ->assertSessionHasErrors(['name', 'phone', 'items']);

        $this->assertDatabaseCount('cart_order_requests', 0);
        Mail::assertNothingSent();
    }
}
